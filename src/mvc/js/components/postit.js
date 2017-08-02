/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 19/07/17
 * Time: 16.14
 */
(function(){
  Vue.component('appui-notes-postit', {
    template: '#bbn-tpl-component-appui-notes-postit',
    data(){
      return {
        showColorPicker: false,
        colorIsChanged: false,
        palette: [
          '#ff6c89', '#fbae3c', '#3bd7c2', '#fd4db0', '#fad2da', '#fbf7ae', '#dae3ea', '#a9c6e8', '#d6d4df', '#cee2d7', '#73cac4', '#fff9a5', '#f9b8bc', '#b0cdeb', '#ee5f35', '#f37d93', '#ffd938', '#fd4db0', '#1dace6', '#e7f150', '#ffd938', 'FBAE3C', '#FD4DB0', '#1CABE3', '#E7F152', '#FFD93A'],
        originalPalette: ['#FBAE3C', '#FD4DB0', '#1CABE3', '#E7F152', '#FFD93A'],
        isMounted: false,
        actualColor: false,
        actualRotation:false,

      }
    },
    props: {
      content: {},
      title: {},
      creation: {},
      color: {},
      uid: {
        type: Number
      },
      editing: {
        type: Boolean,
        default: false
      },
      icon:{
        type: Boolean,
        default: false
      },

    },
    computed:{
    },
    mounted(){
      var vm = this;
      vm.$nextTick(function(){
        bbn.fn.analyzeContent(vm.$el, true);
      });
      vm.isMounted = true;
    },
    beforeMount(){
      var vm = this;
      if ( vm.color ){
        vm.actualColor = vm.color;
      }
      else{
        var r = Math.random(),
          r2 = Math.random(),
          n = r > 0.5 ? r * 7 : r * -7;
        while ( !vm.originalPalette[Math.round(r2*10)] ){
          r2 = Math.random();
        }
        vm.actualColor = vm.originalPalette[Math.round(r2*10)];
      }

      $(vm.$el).css({
        'height':'250px',
        '-moz-transform': 'rotate(' + n + ')',
        '-webkit-transform': 'rotate(' + n + ')',
        '-o-transform': 'rotate(' + n + ')',
        '-ms-transform': 'rotate(' + n + 'deg)',
        'transform': 'rotate(' + n + 'deg)',
      });

      this.$nextTick(function(){
        bbn.fn.analyzeContent(this.$el, true);
      });
    },
    methods: {
      fdate: bbn.fn.fdate,
      update_note(){
        const vm = this;
        let data = {
          title: vm.title,
          content: vm.content,
          id_note: vm.uid
        };
        if ( vm.colorIsChanged ){
          data.color = vm.actualColor;
        }
        bbn.fn.post(vm.$parent.source.root + 'actions/update', data, (res) => {
          if ( res.success ){
            vm.colorIsChanged = false;
          }
        })
      },
      editTitle(){
        alert('editTitle')
      },
      editContent(e){
        const vm = this;
        if ( !vm.editing ){
          vm.$parent.$set(vm.$parent, "editedNote", vm.uid);
          vm.$parent.$forceUpdate();
        }
      },
    },
    updated(){
      var vm = this;
      vm.$nextTick(function(){
        bbn.fn.analyzeContent(vm.$el, true);
      });
    },
    watch:{
      actualColor(oldVal, newVal){
        var vm = this;
        if ( this.isMounted ){
          if( newVal ){
           bbn.fn.log('newVal', newVal)
          }
        }
      }
    }

  });
})();
