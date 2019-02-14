( () => {
  return {
    data(){
      return {
        currentNode: {}, 
        
      }
    },
    computed: {
      topContent(){
        return bookmarks.topContent;
      },
      currentFolder(){
        return bookmarks.currentFolder;
      },
      showLink(){
        return bookmarks.showLink;
      }
    },
    methods:{
      renderUrl(){
        return bookmarks.renderUrl()
      },
      deleteLink(){
        return bookmarks.deleteLink()  
      },
      selectList(a){
        this.currentNode = a;
        bookmarks.listCurrentNode = this.currentNode;
        bbn.fn.log('Selected list', a)
      }
    }
  }
})();