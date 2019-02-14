( () => {
  return {
    props: ['source'],
    computed: {
      imageDom(){
        return bookmarks.imageDom;
      },
      path(){
        return bookmarks.path;
      },
      /*showFolder(){
        return bookmarks.showFolder;
      },*/
      selectedType() {
        return bookmarks.selectedType;
      },
      
    },
    methods: {
      edit(){
        bookmarks.edit();
      },
      remove() {
        if ( this.selectedType === 'link' ){
          return bookmarks.deleteLink();
        }
        else if (this.selectedType === 'folder' ) {
          return bookmarks.deleteFolder();
        }
      },
      renderUrl(url){
        if (this.source.showLink.url.length) {
          if (this.source.showLink.url.indexOf('http') === 0) {
            return this.source.showLink.url;
          } else {
            return 'www.' + this.source.showLink.url;
          }
        }
       //return bookmarks.renderUrl(url)
      }
    }
  }
} )()