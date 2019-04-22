/* jshint esversion: 6 */
(() => {
  let root;
  return {
    props: ['source'],
    methods: {
      edit(row){
        this.$refs.table.edit(row, {
          title: _('Modification of the standard letter'),
          width: '100%',
          height: '100%'
        });
      },
      remove(row){
        this.popup().confirm(bbn._("Are you sure you want to delete this standard letter?"), () => {
          bbn.fn.post(this.source.root + 'actions/mask/delete', {id_note: row.id_note}, (d) => {
            if ( d.success ){
              this.$refs.table.remove(row);
            }
          });
        });
      },
      insert(id_type){
        this.$refs.table.insert({id_type: id_type}, {
          title: _('Creation of a standard letter'),
          width: '100%',
          height: '100%'
        });
      },
      renderUser(row){
        return appui.app.getUserName(row.id_user);
      },
      getButtons(row){
        let btns = [
          {command: this.edit, icon: 'nf nf-fa-edit', text: 'Edit', notext: true}
        ];
        if ( !row.default ){
          btns.push({command: this.remove, icon: 'nf nf-fa-trash', text: 'Delete', notext: true});
        }
        return btns;
      }
    },
    created(){
      root = this.source.root;
    },
    mounted(){
      this.$nextTick(() => {
        this.getPopup().open({
          width: 850,
          height: 200,
          title: bbn._("Warning on standard letters"),
          content: '<div class="bbn-padded"><div class="bbn-b">Warning!</div><br>Here you can modify the standard letters but they use a system of "templates" with which you have to be very cautious. The best is to duplicate an existing standard letter and modify it. Once finished, put it in default if it is used on a feature without choice (eg certificates), and will test it in context. Then you can erase the old one or else redo it if your modification returns an error.</div>'
        });
      });
    },
    components: {
      def: {
        props: ['source'],
        template: `
<i v-if="source.default" class="nf nf-fa-check bbn-lg bbn-green"></i>
<bbn-button v-else icon="nf nf-fa-check bbn-lg bbn-red" @click="makeDefault"></bbn-button>`,
        methods: {
          getTable(){
            return bbn.vue.closest(this, 'bbn-table');
          },
          makeDefault(){
            bbn.fn.post(root + 'actions/mask/default', {
              id_note: this.source.id_note
            }, (d) => {
              if ( d.success ){
                let table = this.getTable();
                let idx = bbn.fn.search(table.currentData, {id_type: this.source.id_type, default: 1});
                if ( idx > -1 ){
                  table.$set(table.currentData[idx], "default", 0);
                }
                this.$set(this.source, "default", 1);
              }
            })
          }
        }
      },
      cat: {
        props: ['source'],
        template: `
<div class="bbn-w-100">
  <div class="bbn-block">
		<span v-text="source.type"></span>
		(<span v-text="num"></span>)
	</div>
  <div class="bbn-block" style="float: right">
    <bbn-button @click="insert"
                icon="nf nf-fa-plus"
                :text="_('Ajouter une lettre type')"
    ></bbn-button>
  </div>
</div>`,
        computed:{
          num(){
	          return bbn.fn.count(this.getTable().currentData, {id_type: this.source.id_type});
          }
        },
        methods: {
          getTable(){
            return bbn.vue.closest(this, 'bbn-table');
          },
          insert(){
        		this.getTable().insert({id_type: this.source.id_type}, bbn._('Creation of a standard letter for') + this.source.type, {
              width: '100%',
              height: '100%'
            });
		      }
	      }
      }
    },
  };
})();