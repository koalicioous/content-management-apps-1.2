<template>
    <div class="container-fluid">
        <div class="row justify-content-end">
            <button class="btn btn-success" @click="newRubrikModal()">
                <i class="fas fa-plus"></i>
                Tambah Rubrik Baru
            </button>
        </div>
        <div v-if="this.rubriks.length < 1">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body text-center">
                            <strong>Whoops! it seems no Rubrik is available</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="row">
                <div v-for="rubrik in rubriks" :key="rubrik.id">
                    <div class="col-md-4">
                        <div class="card rubrik-card" style="width: 18rem;">
                            <div class="card-header">
                                {{rubrik.name}}
                            </div>
                            <div class="card-body">
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>On-Going Task</v-list-item-title>
                                        <v-list-item-subtitle>13</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-divider></v-divider>
                                <v-list-item two-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Engagement Rate</v-list-item-title>
                                        <v-list-item-subtitle>27.3%</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                            <div class="card-footer justify-content-end d-flex">
                                <button class="btn btn-primary">
                                    Detail <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create New Rubrik -->
        <div class="modal fade" id="newRubrikModal" tabindex="-1" role="dialog" aria-labelledby="newRubrikModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Rubrik</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="createNewRubrik()" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                            <div class="form-group">
                                <label>Rubrik name</label>
                                <input v-model="form.name" type="text" name="name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button :disabled="form.busy" type="submit" class="btn btn-success">Create Rubrik</button>
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
                form: new Form({
                    name: ''
                }),
                rubriks: '',
            }
        },
        methods: {
            loadRubriks(){
                axios.get('/rubrik')
                .then(response => {
                    this.rubriks = response.data
                    console.log('Loaded rubriks data')
                }).catch(e => {
                    console.log('Failed to load rubriks data')
                })
            },
            newRubrikModal(){
                $('#newRubrikModal').modal('show')
            },
            createNewRubrik(){
                this.$Progress.start()
                this.form.post('/rubrik')
                .then(response => {
                    this.$Progress.finish()
                    this.loadRubriks()
                    $('#newRubrikModal').modal('hide')
                    Toast.fire({
                        icon: 'success',
                        title: 'New Rubrik is created successfully'
                    })
                })
                .catch(e => {  
                    this.$Progress.fail()
                })
            }
        },
        mounted() {
            this.loadRubriks()
        }
    }
</script>
