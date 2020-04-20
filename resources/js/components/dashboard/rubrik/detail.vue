<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-sm" style="min-height:350px">
                    <div class="card-body">
                        <p class="card-title"><strong>Chart</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card shadow-sm" style="min-height:350px">
                    <div class="card-body">
                            <table class="table my-3">
                            <tbody>
                                <tr>
                                    <td>Post Amount</td>
                                    <td>24</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Total Like</td>
                                    <td>423.630</td>
                                    <td><span class="right badge badge-danger">2.3%</span></td>
                                </tr>
                                <tr>
                                    <td>Total Comment</td>
                                    <td>4.534</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Engagement Rate</td>
                                    <td>23%</td>
                                    <td><span class="right badge badge-success">4%</span></td>
                                </tr>
                                <tr>
                                    <td>Completed Task</td>
                                    <td>34</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm overflow-auto">
                    <div class="card-header">
                        <button class="btn btn-success btn-block float-right" @click="newPostModal()">
                            <i class="fas fa-plus"></i>
                            Schedule New Post
                        </button>
                    </div>
                    <div class="card-body post-schedule-card">
                        <div v-if="posts.length < 1">
                            <p class="text-center"><strong>Whoops, no scheduled post is available</strong></p>
                        </div>
                        <div v-else>
                            <table class="table">
                                <thead>
                                    <th>Title</th>
                                    <th>Publish Date</th>
                                    <th>Tasks</th>
                                    <th>Progress</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <tr v-for="post in posts" :key="post.id">
                                        <td>{{ post.name }}</td>
                                        <td>{{ post.publish_date | formatDate }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button class="btn btn-secondary" @click="postCogs(post)">
                                                <i class="fas fa-cogs"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm" style="min-height:350px">
                    <div class="card-body">
                        <p class="card-title">
                            <strong>On-Going Tasks</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>



        <!-- Schedule New Post -->
        <div class="modal fade" id="newPostModal" tabindex="-1" role="dialog" aria-labelledby="newPostModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Schedule New Post in {{rubrik.name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <form @submit.prevent="schedulePost()" @keydown="newPost.onKeydown($event)">
                        <div class="modal-body">
                                <div class="form-group">
                                    <label>Post Title</label>
                                    <input v-model="newPost.name" type="text" name="name"
                                        class="form-control" :class="{ 'is-invalid': newPost.errors.has('name') }">
                                    <has-error :form="newPost" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <date-picker name="publish_date" v-model="newPost.publish_date" type="date" valueType="YYYY/MM/DD" format="ddd, DD MMM YYYY"
                                    :class="{ 'is-invalid': newPost.errors.has('publish_date') }" placeholder="Pick a publish date"></date-picker>
                                    <has-error :form="newPost" field="publish_date"></has-error>
                                </div>  
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button :disabled="newPost.busy" type="submit" class="btn btn-success">Schedule Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Post Configuration Modal -->
        <div class="modal fade" id="PostCogsModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ postData.name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Work Progress</strong></p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-angle-double-right" style="color:#3490d"></i>
                                    Unfinished Tasks
                                    <button class="btn btn-success btn-sm float-right" @click="newTaskModal()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="card-body task-post-card unfinished-task">
                                    <div v-if="unfinishedTasks.length < 1">
                                        <p class="text-center">
                                            <strong>Whoops! No unfinished task in this post</strong>
                                        </p>
                                    </div>
                                    <div v-else>
                                        <div v-for="unf in unfinishedTasks" :key="unf.id">
                                            <div class="card shadow-sm">
                                                <div class="card-body">
                                                    <div class="task-title my-2">Make Final Design</div>
                                                    <div class="task-description">Di sini bakal ditulisin apa aja yang harus dilakuin di task ini</div>
                                                    <div class="task-resp my-2 float-right">Ilham Fathurrahman</div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-success btn-sm">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-check-circle" style="color:#38c172"></i>
                                    Completed Task
                                    <button class="btn btn-sm float-right" style="color:#fffff">
                                        <i class="fas fa-angle-double-up"></i>
                                    </button>
                                </div>
                                <div class="card-body task-post-card">

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" @click="deletePost(postData)">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>

        <!-- New Task Modal -->
        <div class="modal fade" id="newTask" tabindex="-1" role="dialog" aria-labelledby="newTaskLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content shadow">
                    <form @submit.prevent="createTask()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Order</label>
                                <input v-model="newTask.order" type="text" name="order"
                                    class="form-control" :class="{ 'is-invalid': newTask.errors.has('order') }">
                                <has-error :form="newTask" field="order"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Description (Optional)</label>
                                <input v-model="newTask.desc" type="text" name="desc"
                                    class="form-control" :class="{ 'is-invalid': newTask.errors.has('desc') }">
                                <has-error :form="newTask" field="desc"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Responsible</label>
                                <select v-model="newTask.userId" name="userId" id="userId"
                                type="text" class="form-control" :class="{ 'is-invalid': newTask.errors.has('userId') }">
                                    <option v-for="(user, key) in users" :value="user.id" :key="key">{{user.name}}</option>
                                </select>
                                <has-error :form="newTask" field="role"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button :disabled="newTask.busy" type="submit" class="btn btn-success">Assign Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            rubrikId: this.$route.params.id,
            rubrik: '',
            posts: '',
            tasks: '',
            unfinishedTasks: '',
            finishedTasksInPost: '',
            users: '',
            newPost: new Form({
                name: '',
                publish_date: '',
                is_published: '',
                rubrik_id: this.$route.params.id,
            }),
            newTask: new Form({
                order: '',
                desc: '',
                userId: '',
                postId: '',
            }),
            postData: '',
        }
    },
    methods: {
        loadRubrik(){
            axios.get('/rubrik/loadrubrik/' + this.rubrikId)
            .then(response => {
                this.rubrik = response.data.rubrik
                this.posts = response.data.posts
                this.tasks = response.data.tasks
                this.users = response.data.users
            })
            .catch(e => {
                console.log('failed to load rubrik data')
            })
        },
        loadPosts(){
            axios.get('/post?rubrik=' + this.$route.params.id)
            .then(response => {
                this.posts = response.data
            })
        },
        loadTasksInPost(id){
            axios.get('/task/post?post=' + id)
            .then(response => {
                console.log(response)
            })
        },
        newPostModal(){
            this.newPost.reset()
            $('#newPostModal').modal('show')
        },
        newTaskModal(){
            this.newTask.reset()
            this.newTask.postId = this.postData.id
            $('#newTask').modal('show')
        },
        createTask(){
            this.newTask.post('/task')
            .then(response => {
                console.log(response.data)
            })
        },
        schedulePost(){
            this.$Progress.start()
            this.newPost.post('/post')
            .then(response => {
                console.log(response)
                this.$Progress.finish()
                this.loadPosts()
                $('#newPostModal').modal('hide')
                Toast.fire({
                    icon: 'success',
                    title: 'New Post is successfully scheduled'
                })
            })
        },
        postCogs(post){
            this.postData = post
            this.loadTasksInPost(post.id)
            $('#PostCogsModal').modal('show')
        },
        deletePost(post){
            Swal.fire({
                title: 'Yakin mau dihapus?',
                text: "Gak bisa dibalikin loh",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.value) {
                axios.delete('/post/'+ post.id)
                .then(response => {
                    $('#PostCogsModal').modal('hide')
                    this.loadPosts()
                    Toast.fire({
                        icon: 'success',
                        title: post.name + ' is deleted successfully'
                    })
                })
                .catch(e =>{
                    console.log('failed to delete post')
                })
                
            }
            })
        }
    },
    mounted(){
        this.loadRubrik()
    }

}
</script>