/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 23/02/2018
 * Time: 15:34
 */
(() => {
  return {
    data(){
      return {
        showForm: false,
        formData: {
          title: '',
          content: '',
          postit: 0,
          type: this.source.id_type
        }
      }
    },
    methods: {
      shorten: bbn.fn.shorten,
      html2text: bbn.fn.html2text,
      afterSubmit(d){
        if ( d.success ){
          appui.success('Saved');
          this.closeForm();
          bbn.vue.closest(this, 'bbns-widget').reload();
        }
        else {
          appui.error();
        }
      },
      closeForm(){
        this.$refs.form.reset();
        this.toggleForm();
      },
      openNote(note){
        appui.$refs.tabnav.activeTab.getPopup().open({
          title: note.title,
          width: '70%',
          height: '70%',
          component: 'appui-notes-popup-note',
          source: note
        });
      },
      openPostit(){
        bbn.fn.link(appui.plugins['appui-notes'] + '/post-it');
      },
      toggleForm(){
        this.showForm = !this.showForm;
      },
      userName(usr){
        return appui.app.getUserName(usr);
      }
    },
    beforeMount(){
      bbn.vue.setComponentRule('notes/components/', 'appui-notes');
      bbn.vue.addComponent('popup/note');
      bbn.vue.unsetComponentRule();
    }
  };
})();