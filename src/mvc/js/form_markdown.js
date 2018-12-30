(() => {
  return {
    data(){
      return {
        root: appui.plugins['appui-notes']
      }
    },
    methods: {
      afterSubmit(d){
        if ( d.success ){
          appui.success(bbn._('Saved'));
        }
        else {
          appui.error();
        }
      }
    }
  }
})();