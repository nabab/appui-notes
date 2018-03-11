/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 06/03/2018
 * Time: 15:53
 */
(() => {
  return {
    props: ['source'],
    methods: {
      insert(){
        this.$refs.table.insert({}, {
          title: 'New message',
          width: '70%',
          height: '70%'
        });
      },
      edit(row, col, idx){
        this.$refs.table.edit(row, {
          title: 'Edit message',
          width: 800,
          height: 600
        }, idx);
      },
      see(row){
        appui.$refs.tabnav.activeTab.popup().open({
          title: row.title,
          width: 800,
          height: 600,
          component: 'appui-notes-popup-note',
          source: row
        });
      },
      rendertAuthor(row){
        return appui.userName(row.id_user);
      }
    },
    beforeMount(){
      bbn.vue.setComponentRule(this.source.root + 'components/', 'appui-notes');
      bbn.vue.addComponent('popup/note');
      bbn.vue.unsetComponentRule();
    },
    components: {
      'appui-notes-news-new': {
        props: ['source'],
        template: '#appui-notes-news-new',
        methods: {
          success(d){
            if ( d. success ){
              appui.success(bbn._('Saved'));
              appui.$refs.tabnav.activeTab.getComponent().$refs.table.updateData();
            }
            else {
              appui.error(bbn._('Error'));
            }
          }
        }
      }
    }
  };
})();