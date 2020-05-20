(() => {
  return {
    props: {
      source: {
        type: Object
      },
      data: {
        type: Object,
        default(){
          return {}
        }
      },
      dataUrl: { 
        type: String,
        default: appui.plugins['appui-notes'] + '/data/versions'
      },
      actionUrl: {
        type: String,
        default: appui.plugins['appui-notes'] + '/data/version'
      }
    },
    data(){
      return {
        root: appui.plugins['appui-notes'] + '/',
        currentVersion: this.source.version
      }
    },
    computed: {
      currentCreator(){
        return bbn.fn.getField(appui.app.users, 'text', {value: this.source.creator});
      },
      currentDate(){
        return moment(this.source.creation).format('DD/MM/YYYY HH:mm');
      },
      hasVersions(){
        return this.source.hasVersions;
      }
    },
    methods: {
      map(v){
        return {
          text: v.value + ' - ' + moment(v.creation).format('DD/MM/YYYY HH:mm'),
          value: v.value
        }
      }
    },
    watch: {
      currentVersion(newVal){
        if ( this.data.id ){
          this.post(this.actionUrl, {
            id_note: this.data.id,
            version: newVal
          }, d => {
            if ( d.success && d.data ){
              this.$emit('version', d.data);
            }
          })
        }
      }
    } 
  }
})();