(() => {
  return {
    data(){
      return {
        root: appui.plugins['appui-note']
      }
    },
    methods: {
      afterSubmit(d){
        bbn.fn.log('fa',d)
        if ( d.data.success || d.success ){
          appui.success(bbn._('Saved'));
        }
        else {
          appui.error();
        }
      }
    }
  }
})();