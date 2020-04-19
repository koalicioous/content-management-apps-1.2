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
                <div class="card shadow-sm" style="min-height:350px">
                    <div class="card-header">
                        <button class="btn btn-success btn-block float-right">
                            <i class="fas fa-plus"></i>
                            Schedule New Post
                        </button>
                    </div>
                    <div class="card-body">
                        
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
    </div>
</template>

<script>
export default {
    data(){
        return {
            rubrikId: this.$route.params.id,
            rubrik: '',
            newPost: new Form({
                name: '',
                
            })
        }
    },
    methods: {
        loadRubrik(){
            axios.get('/rubrik/loadrubrik/' + this.rubrikId)
            .then(response => {
                console.log(response.data)
            })
            .catch(e => {
                console.log('failed to load rubrik data')
            })
        },
        scheduleNewPost(){

        }
    },
    mounted(){
        this.loadRubrik()
        console.log(this.rubrik)
    }

}
</script>