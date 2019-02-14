/*avevo provato su questa tabella a fare un componente interno per le nuove note ma non lo vede*/
(function(){
  return {
    data(){
      return {
        action: '',
        root: appui.plugins['appui-notes'] + '/',
        span: '<span title="' + bbn._('Click on the first column of this row to view full content') + '">...</span>'
      }
    },
    methods: {
      markdown(row){
        bbn.fn.log('roooooooooooooooooow')
        if(row){
          
          bbn.fn.link('notes/form_markdown/' + row.id);
        }
        else{
          
          bbn.fn.link('notes/form_markdown/');
        }
      },
      rte(row){
        bbn.fn.link('notes/form_rte/' + row.id_note);
      },
      insert(){
        this.getPopup().open({
            width: 800,
            height: 600,
            title: bbn._("New Note") ,
            component: 'apst-adherent-form-note',
        })
      },
      edit(row){
        return this.$refs.table.edit(row, bbn._("Editing a mailing"));
      },
      creator(row){
        return  appui.app.getUserName(row.creator);
      },
      last_mod_user(row){
        return  appui.app.getUserName(row.id_user);
      },
      title(row){
        //return row.title
        if (!row.title || (row.title === '') && row.content) {
          if ( bbn.fn.isNumber(row.content) ){
            row.content = row.content.toString();
          }
          return row.content.substr(0,50)+ this.span;
        }
        else{
          return row.title
        }
      }
    },
    components: {
      'apst-notes-content': {
        template: '#apst-notes-content',
        props: ['source'],
        methods: {

        }
      },
      'apst-new-note': {
        template: '#apst-new-note',
        props: ['source'],
        methods: {

        }
      },
    }
  }
})();