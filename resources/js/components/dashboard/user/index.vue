<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header">Active Users</div>
                    <div class="card-body">
                        <div v-if="this.users.length < 1">
                            <p class="text-center"><strong>Whoops! Active User is Available to Show</strong></p>
                        </div>
                        <div v-else>
                            <table class="table">
                                <thead>
                                    <th>User ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Configs</th>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users" :key="user.id">
                                        <td>{{ user.id }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.role }}</td>
                                        <td>
                                            <button class="btn btn-primary">
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
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header"><strong>Unverified Users</strong></div>

                    <div class="card-body">
                        <div v-if="this.unverifieds.length < 1">
                            <p class="text-center"><strong>Whoops! No Unverified User is Available to Show</strong></p>
                        </div>
                        <div v-else>
                            <table class="table">
                                <thead>
                                    <th>User ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Configs</th>
                                </thead>
                                <tbody>
                                    <tr v-for="unv in unverifieds" :key="unv.id">
                                        <td>{{ unv.id }}</td>
                                        <td>{{ unv.name }}</td>
                                        <td>{{ unv.email }}</td>
                                        <td>
                                            <button class="btn btn-primary" @click="editUnverifiedUser(unv)">
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
        </div>

        <!-- Unverified User Configuration Configuration -->
        <div class="modal fade" id="UnverifiedCogModal" tabindex="-1" role="dialog" aria-labelledby="UnverifiedCogModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Config</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <form @submit.prevent="updateRole()" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>User ID</label>
                                <input v-model="CogForm.id" type="text" name="id"
                                    class="form-control" :class="{ 'is-invalid': CogForm.errors.has('id') }" readonly>
                                <has-error :form="CogForm" field="is"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Full Name</label>
                                <input v-model="CogForm.name" type="text" name="name"
                                    class="form-control" :class="{ 'is-invalid': CogForm.errors.has('name') }" readonly>
                                <has-error :form="CogForm" field="is"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="CogForm.email" type="text" name="email"
                                    class="form-control" :class="{ 'is-invalid': CogForm.errors.has('email') }" readonly>
                                <has-error :form="CogForm" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select v-model="CogForm.role" name="role" id="role"
                                type="text" class="form-control" :class="{ 'is-invalid': CogForm.errors.has('role') }">
                                    <option v-for="(role, key) in roles" :value="role" :key="key">{{role}}</option>
                                </select>
                                <has-error :form="CogForm" field="role"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Update Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                CogForm: new Form({
                    id: '',
                    name: '',
                    email: '',
                    role: '',
                }),
                roles: [],
                unverifieds: '',
                users: []
            }
        },
        methods: {
            loadRoles(){
                axios.get('/role')
                .then(response => {
                    for(let i = 0;i < response.data.length; i++){
                        this.roles[i] = response.data[i].name
                    }
                    console.log('Success to load Roles data')
                })
                .catch(response => {
                    console.log('Failed to load Roles data')
                })
            },
            loadUnverified(){
                axios.get('/user/unverified')
                .then(response => {
                    this.unverifieds = response.data
                    console.log('Success to load Unverfied Users Loaded')
                })
                .catch(response => {
                    console.log('Failed to load unverified users')
                })
            },
            loadUsers(){
                axios.get('/user/active')
                .then(response => {
                    this.users = response.data
                    console.log('Success to load Users')
                })
                .catch(response => {
                    console.log('Failed to Load Users')
                })
            },
            editUnverifiedUser(user){
                $('#UnverifiedCogModal').modal('show')
                this.CogForm.id = user.id
                this.CogForm.name = user.name
                this.CogForm.email = user.email
                this.CogForm.role = user.role
            },
            updateRole(){
                this.$Progress.start()
                this.CogForm.post('user/' + this.CogForm.id + '/role')
                .then(response => {
                    this.$Progress.finish()
                    this.loadUnverified()
                    $('#UnverifiedCogModal').modal('hide')
                    Toast.fire({
                        icon: 'success',
                        title: this.CogForm.name + ' Role is updated'
                    })
                })
                .catch(response => {
                    console.log('Failed to Update Role')
                })
            }
        },
        created() {
            this.$Progress.start()
        },
        mounted() {
            this.loadRoles()
            this.loadUsers();
            this.loadUnverified()
            this.$Progress.finish()
        }
    }
</script>
