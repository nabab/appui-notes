/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 18/07/17
 * Time: 17.26
 */


(function(){
  return {

    data(){
      return bbn.fn.extend(true, this.source, {editedNote: false}, {choosing:false});
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