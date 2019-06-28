/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 19/07/17
 * Time: 16.14
 */
(() => {
  return {
    props: {
      content: {},
      title: {},
      creation: {},
      color: {},
      id_note: {
        type: String
      },
      icon:{
        type: Boolean,
        default: false
      }
    },
    data(){
      return {
        showColorPicker: false,
        colorIsChanged: false,
        palette: [
          '#ff6c89', '#fbae3c', '#3bd7c2', '#fd4db0', '#fad2da', '#fbf7ae', '#dae3ea', '#a9c6e8', '#d6d4df', '#cee2d7', '#73cac4', '#fff9a5', '#f9b8bc', '#b0cdeb', '#ee5f35', '#f37d93', '#ffd938', '#fd4db0', '#1dace6', '#e7f150', '#ffd938', 'FBAE3C', '#FD4DB0', '#1CABE3', '#E7F152', '#FFD93A'],
        originalPalette: ['#FBAE3C', '#FD4DB0', '#1CABE3', '#E7F152', '#FFD93A'],
        isMounted: false,
        actualColor: this.color || false,
        actualRotation: bbn.fn.randomInt(-15,15),
        editing: false,
        isModified: false,
        newData: {
          content: this.html2text(this.content),
          title: this.html2text(this.title)
        }
      }
    },
    computed: {
      getStyle(){
        return '-moz-transform: rotate(' + this.actualRotation + 'deg); ' +
          '-webkit-transform: rotate(' + this.actualRotation + '); ' +
          '-o-transform: rotate(' + this.actualRotation + '); ' +
          '-ms-transform: rotate(' + this.actualRotation + 'deg); ' +
          'transform: rotate(' + this.actualRotation + 'deg); ' +
          'backgroundColor: ' + this.actualColor;
      }
    },
    methods: {
      fdate: bbn.fn.fdate,
      html2text: bbn.fn.html2text,
      edit(){
        this.$nextTick(() => {
          if ( this.isModified ){
            bbn.fn.post(appui.plugins['appui-notes'] + '/actions/update', bbn.fn.extend(true, {}, this.newData, {
              id_note: this.id_note,
              color: this.actualColor
            }), (d) => {
              if ( d.success ){
                this.isModified = false;
                this.editing = false;
                appui.success(bbn._('Saved'));
              }
              else {
                appui.error();
              }
            });
          }
          else {
            appui.warning(bbn._('No changes'));
            this.editing = false;
          }
        });
      },
      editMode(e){
        if ( !this.editing ){
          this.editing = true;
        }
        setTimeout(() => {
          //$(e.target).focus();
          e.target.focus();
        }, 200);
      },
      removeNote(){
        bbn.fn.post(appui.plugins['appui-notes'] + '/actions/delete',{id_note: this.id_note}, d =>{
          if ( d.success ){
            appui.success(bbn._('Delete'));
            this.$nextTick(()=>{
              bbn.vue.closest(this, 'bbns-container').reload();
            });
          }
          else{
            appui.error(bbn._('Error while deleting'));
          }
        });
      },
      changeText(field, e){
        //let newVal = this.html2text($(e.target).html());
        let newVal = this.html2text(e.target.innerHTML);
        if ( newVal !== this.newData[field] ){
          this.newData[field] = newVal;
          this.isModified = true;
        }
      }
    },
    beforeMount(){
      if ( !this.color ){
        let r = Math.random();
        while ( !this.originalPalette[Math.round(r*10)] ){
          r = Math.random();
        }
        this.actualColor = this.originalPalette[Math.round(r*10)];
      }
    },
    mounted(){
      this.isMounted = true;
    }
  }
})();
