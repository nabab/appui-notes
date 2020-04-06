document.addEventListener("DOMContentLoaded", () => {
  bbn.fn.init({
    env: {
      //lang: data.lang,
      connection_failures: 0,
      connection_max_failures: 10,
      //logging: data.is_dev || data.is_test,
    }
  });

  new Vue({
    el: 'div.appui-cms-preview',
    props: ['source'],
    data(){
      return{
        logo: false,
        note: {},
        message: false//'Message opzionale'
      }
    }, 
    computed:{
      info(){
        let st = '';
        if  (this.note.start !== null ){
          st += '<span class="bbn-w-100">' + bbn._('Published') + '</span>' +
          '<br> <span class="bbn-xs bbn-i bbn-w-100">Start: ' + bbn.fn.fdatetime(this.note.start) + '</span>'
         	if ( this.note.end !== null){
            st +=  '<br> <span class="bbn-xs bbn-i bbn-w-100">End: ' + bbn.fn.fdatetime(this.note.end) + '</span>'
          }
        }
        else{
          st += bbn._('Draft')
        }
				return st;
      }
    },
    beforeMount(){
      this.note = data;
    }
  });
});