// Javascript Document
(()=>{
  return {
    data(){
      return {
        searchMedia: '',
        medias: []
      }
    },
    methods: {
      
    },
    beforeMount(){
      this.post('notes/media/media_browser', {
        start: 0,
        limit: 150
      }, (d) => {
        this.medias = d.medias;
      })
    }
  }
  
})()