<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm" style="min-height:350px">
                    <div class="card-body">
                        <p class="card-title"><strong>Chart</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm" style="min-height:350px">
                    <div class="card-body">
                        <p class="card-title"><strong>Work Summary</strong></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm" style="min-height:350px">
                    <div class="card-body">
                        <p class="card-title">
                            <strong>Calendar and Scheduled Post</strong>
                        </p>
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
        }
    },
    methods: {
        loadRubrik(){
            axios.get('/rubrik/' + this.rubrikId)
            .then(response => {
                this.rubrik = response.data
            })
            .catch(e => {
                console.log('failed to load rubrik data')
            })
        }
    },
    mounted(){
        this.loadRubrik()
        console.log(this.rubrik)
    }

}
</script>