/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 18/07/17
 * Time: 17.26
 */


(function(){
  return {

    beforeMount: function(){
      bbn.vue.setComponentRule(this.source.root + 'components/', 'appui-notes');
      bbn.vue.addComponent('postit');

      bbn.vue.unsetComponentRule();
    },
    mounted(){
      bbn.fn.log('this note', this);
      this.$nextTick(function(){
        bbn.fn.analyzeContent(this.$el, true);
      });
    },
    data: function(){
      return $.extend(this.source, {editedNote: false}, {choosing:false});
    },
    watch: {
      editedNote(newVal, oldVal){
        bbn.fn.log("CHanged edited note: " + newVal + '/' + oldVal)
      }
    },
    methods: {
      isEditing(val){
        bbn.fn.log(val);
        return val === this.editedNote;
      },
    },
    updated(){
      bbn.fn.log('updated note');
      this.$nextTick(function(){
        bbn.fn.analyzeContent(this.$el, true);
      });
    }
  }
})();