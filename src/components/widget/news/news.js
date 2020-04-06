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
        formData:{}
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
          appui.success(bbn._('Saved'));
          this.closest('bbn-widget').reload();
          this.closeForm();
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
        appui.getRef('nav').activeContainer.getPopup().open({
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
        let obj = {
          title: '',
          content: '',
          private: 0,
          locked: 0,
          type: this.source.id_type,
          start: moment().format('YYYY-MM-DD HH:mm:ss'),
          end: moment().add(10, 'minutes').format('YYYY-MM-DD HH:mm:ss')
        };
        this.$set(this, 'formData', obj);
        this.showForm = !this.showForm;
      },
      userName(usr){
        return appui.app.getUserName(usr);
      }
    }
  };
})();
