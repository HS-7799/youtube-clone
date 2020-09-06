<template>
    <div class="p-3">
        <div class="alert alert-danger" v-if="error" >
            {{ error }}
        </div>
        <div class="text-center" v-if="!selected" >
            <input type="file" ref="upload" multiple @change="upload" >
            <img src="/images/video.png" @click="$refs.upload.click()" alt="">
            <p>Upload videos</p>

        </div>
        <div v-else >

            <div class="p-3" v-for="(video,index) in videos" :key="index" >

                <div class="row progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" :style="{width : (progress[video.name] || video.percentage)+'%' }">
                        {{ video.percentage ? video.percentage === 100 ? 'Video processing completed' : 'Processing' : 'Uploading' }}
                    </div>
                </div>
                <div class="row mt-2" >
                    <div class="col-4 thumbnail bg-secondary" >
                        <div v-if="!video.thumbnail">
                            Loading thumbnail...
                        </div>
                        <img v-else :src="'/storage'+video.thumbnail" width="100%" height="100%" alt="">
                    </div>
                    <div class="col">
                        <a v-if="video.percentage && video.percentage === 100" :href="`/videos/${video.id}`">
                            {{ video.title }}
                        </a>
                        <h4 v-else >
                            {{ video.name || video.title }}
                        </h4>
                    </div>
                </div>
                <p class="text-danger" v-if="errors[video.name]" >
                    {{ errors[video.name].video[0] }}
                </p>
            </div>

        </div>
    </div>
</template>

<script>
export default {

    props : ['id'],
    data : () => ({
        selected : false,
        videos : [],
        errors : {},
        error : null,
        progress : {},
        uploads : [],
        intervals : {}
    }),
    methods : {
        upload()
        {
            this.selected = !this.selected;
            this.videos = Array.from(this.$refs.upload.files);

            const uploaders = this.videos.map(video => {

                this.progress[video.name] = 0;
                const form = new FormData();

                form.append('video',video);
                form.append('title',video.name);
                return axios.post(`/channels/${this.id}/videos`,form,{
                    onUploadProgress : (event) => {
                        this.progress[video.name] = ((event.loaded/event.total)*100);
                        this.$forceUpdate();
                    }
                })
                .then((response) => { // data here is the $video uploaded

                    this.uploads.push(response.data)

                })
                .catch((err) => {
                    if(err.response.data.errors)
                    {
                        this.errors[video.name] = err.response.data.errors
                    }
                    this.error = err.response.data.message
                    this.progress[video.name] = 0;

                });


            });

            axios.all(uploaders)
                .then(() => {
                    this.videos = this.uploads

                    this.videos.forEach(video => {

                        this.intervals[video.id] = setInterval(() => {
                            axios.get(`/videos/${video.id}`)
                            .then((response) => {

                                if(response.data.percentage === 100)
                                {
                                    clearInterval(this.intervals[video.id])
                                }


                                this.videos = this.videos.map(v => {
                                    if(v.id === response.data.id)
                                    {
                                        return response.data;
                                    }
                                        return v;

                                });

                            })
                            .catch((err) => {
                                console.log(err.response.data)
                            });
                        },3000)
                    })
                })
        }
    }

}
</script>




<style scoped>
img
{
    cursor:pointer;
}
input{
    display: none;
}
.thumbnail
{
    height: 130px;
    color: white;
}
</style>
