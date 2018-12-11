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
        notesRoot: appui.plugins['appui-notes'],
        formData: {
          title: '',
          content: '',
          private: 0,
          locked: 0,
          type: this.source.id_type,
          start: moment().format('YYYY-MM-DD HH:mm:ss'),
          end: ''
        }
      }
    },
    methods: {
      validForm(){
        if ( this.formData.title.length ){
          return true;
        }
        else{
          appui.error(bbn._('Enter a title for the note'));
          return false;
        }
      },
      shorten: bbn.fn.shorten,
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
        this.showForm = false;
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
      openNews(){
        bbn.fn.link(appui.plugins['appui-notes'] + '/news');
      },
      toggleForm(){
        this.showForm = !this.showForm;
        if ( this.showForm ){
          this.formData.start = moment().format('YYYY-MM-DD HH:mm:ss');
        }
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