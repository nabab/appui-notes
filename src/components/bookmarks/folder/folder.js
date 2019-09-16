(()=>{
  return{
    props: ['source'],
    data(){
      return {
        text: '',
      }
    },
    computed: {
      path() {
        return bookmarks.path;
      },
      parent(){
        return bookmarks.parent;
      },
      remakeTree() {
        return bookmarks.remakeTree;
      },
    },
    methods: {
      closeForm() {
        bookmarks.showFormFolder = false;
      },
      removeParent() {
        bookmarks.removeParent();
      },
      submit(){
        let 
        real_parent = '',
        obj = {
          parent: this.parent ,
          text: this.text,
          type: 'folder'
        };
        // :validation is not considered in the form so I call the method
        if ( this.text === 'ROOT'){
          appui.error(bbn._('The name of the folder cannot be \'ROOT\''));
          return false;
        }
        else if (this.text === '') {
          appui.error(bbn._('The name of the folder cannot be an empty string'));
          return false;
        }
        this.post('notes/actions/bookmarks/insert', obj, (d) => {
          if (d.success) {
            bookmarks.showFormFolder = false;
            bookmarks.currentNode = {};
            bookmarks.insert(obj, d.bookmarks);
          } else {
            appui.error(d.error);
          }
      });
      },  
      folder() {
        //bbn.fn.log('validationnnnnnnnnnnnnnnnnnnnn', this.text)
        //return false
        if ( !bookmarks.selectedType || (bookmarks.selectedType === 'folder') || this.text !== 'ROOT') {
          return true;
        }
        else if ( this.text === 'ROOT' ){
          appui.error(bbn._('The name of the folder cannot be \'ROOT\''))
          bbn.fn.log('validationnnnnnnnnnnnnnnnnnnnn', this.text)
          return false;
        }
        else{
          return false;
        }
      },
   
    }
  }
})();