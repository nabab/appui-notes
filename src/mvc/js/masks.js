/* jshint esversion: 6 */
(() => {
  let root;
  return {
    props: ['source'],
    methods: {
      edit(row){
        this.$refs.table.edit(row, {
          title: 'Modification de la lettre-type',
          width: '100%',
          height: '100%'
        });
      },
      remove(row){
        this.popup().confirm(bbn._("Souhaitez-vous vraiment supprimer cette lettre-type?"), () => {
          bbn.fn.post(this.source.root + 'actions/mask/delete', {id_note: row.id_note}, (d) => {
            if ( d.success ){
              this.$refs.table.remove(row);
            }
          });
        });
      },
      insert(id_type){
        this.$refs.table.insert({id_type: id_type}, {
          title: 'Création d\'une lettre-type',
          width: '100%',
          height: '100%'
        });
      },
      renderUser(row){
        return apst.userName(row.id_user);
      },
      getButtons(row){
        let btns = [
          {command: this.edit, icon: 'fa fa-edit', text: 'Mod.', notext: false}
        ];
        if ( !row.default ){
          btns.push({command: this.remove, icon: 'fa fa-trash', text: 'Suppr.', notext: false});
        }
        return btns;
      }
    },
    created(){
      root = this.source.root;
    },
    mounted(){
      this.$nextTick(() => {
        this.popup({
          width: 850,
          height: 200,
          title: bbn._("Avertissement sur les lettres types"),
          content: '<div class="bbn-padded"><div class="bbn-b">Attention!</div><br>Ici vous pouvez modifier les lettres types mais elles utilisent un système de "templates" avec lequel il vous faut être très précautionneu. Le mieux est de dupliquer une lettre-type existante et de la modifier. Une fois terminée, mettez-là en défaut si elle est utilisée sur une fonctionnalité sans choix (ex: attestations), et allez la tester dans son contexte. Alors vous pourrez effacer l\'ancienne ou bien la refaire passer en défaut si votre modification renvoie une erreur.</div>'
        });
      });
    },
    components: {
      def: {
        props: ['source'],
        template: `
<i v-if="source.default" class="fa fa-check bbn-lg bbn-green"></i>
<bbn-button v-else icon="fa fa-check bbn-lg bbn-red" @click="makeDefault"></bbn-button>`,
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
                icon="fa fa-plus"
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
        		this.getTable().insert({id_type: this.source.id_type}, bbn._('Création d\'une lettre-type pour ') + this.source.type, {
              width: '100%',
              height: '100%'
            });
		      }
	      }
      }
    },
  };
})();