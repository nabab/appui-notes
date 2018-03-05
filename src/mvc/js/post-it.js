/**
 * Created by BBN on 06/11/2016.
 */

(() => {
  return {
    created(){
      bbn.vue.setComponentRule(this.source.root + 'components/', 'appui-notes');
      bbn.vue.addComponent('postit');
      bbn.vue.unsetComponentRule();
    }
  }
})();