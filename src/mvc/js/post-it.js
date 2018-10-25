/**
 * Created by BBN on 06/11/2016.
 */
(() => {
  return {
    data(){
      return{
        rechercher: ''
      }
    },
    computed:{
      notes(){
        let i = 0,
            title = '',
            arr = [];
        if ( this.source.notes.length && this.rechercher.length ){
          bbn.fn.each(this.source.notes, note => {
            title =  note.title.toLowerCase();
            if ( title.indexOf(this.rechercher.toLowerCase()) === 0 ){
              arr.push(note);
            }
          });
          return arr;
        }
        else{
          return this.source.notes;
        }
      }
    }
  }
})();
