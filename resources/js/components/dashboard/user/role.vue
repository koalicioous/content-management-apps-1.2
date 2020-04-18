<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header">
                        Roles
                        <button class="btn btn-success float-right" @click="openNewRoleModal()">
                            <i class="fas fa-plus"></i>
                            Add New Role
                        </button>
                    </div>

                    <div class="card-body overflow-auto" style="max-height:700px">
                        <div v-if="this.roles.length < 1">
                            <strong><p class="text-center">Ups, it seems that no role is available in this project</p></strong>
                        </div>
                        <div v-else>
                            <table class="table">
                                <thead>
                                    <th>Role Name</th>
                                    <th class="text-center">Member Count</th>
                                    <th class="text-center">Config</th>
                                </thead>
                                <tbody>
                                    <tr v-for="role in roles" :key="role.id">
                                        <td>{{ role.name }}</td>
                                        <td class="text-center">{{ role.count }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-secondary">
                                                <i class="fas fa-cogs"></i>
                                            </button>
                                            <button class="btn btn-danger" @click="deleteRole(role)">
                                                <i class="fas fa-trash"></i>
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

        <!-- Create New Role -->
        <div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New User Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="createNewRole()" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                            <div class="form-group">
                                <label>Role Name</label>
                                <input v-model="form.name" type="text" name="name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button :disabled="form.busy" type="submit" class="btn btn-success">Create Role</button>
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
                roles: [],
                form: new Form({
                    name: '',
                }),
            }
        },
        methods: {
            loadRoles(){
                axios.get('/role')
                .then(response => {
                    this.roles = response.data
                })
            },
            openNewRoleModal(){
                this.form.reset()
                $('#newRoleModal').modal('show')
            },
            createNewRole(){
                this.$Progress.start()
                console.log(this.form.name)
                this.form.post('/role').then(response => {
                    $('#newRoleModal').modal('hide')
                    this.loadRoles()
                    this.$Progress.finish()
                    Toast.fire({
                        icon: 'success',
                        title: 'New Role is created successfully'
                    })
                }).catch(response => {
                    this.$Progress.fail()
                })
            },
            deleteRole(role){
                Swal.fire({
                    title: 'Delete ' + role.name + '?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    this.$Progress.start()
                    axios.delete('/role/' + role.id).then(response => {
                        console.log(response)
                        Toast.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    this.loadRoles()
                    this.$Progress.finish()
                    })
                }
                })
            }
        },
        mounted() {
            this.$Progress.finish()
        },
        created() {
            this.$Progress.start()
            this.loadRoles()
        }
    }
</script>
