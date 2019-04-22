// Javascript Document
(() => {
  return {
    created(){
      window.bookmarks = this;
    },
    data(){
      return{
        currentNode: {},
        showFormLink: false,
        showFormFolder: false,
        parent: 'ROOT',
        path: '/',
        imageDom: 'pm/image/tmp/',
        uid: false,
        remakeTree: false,
        realTreeSource: [],
        currentFolder : {},
        showLink: {},
        showFolder: {},
        editing:false
      } 
    },
    computed: {
      /*showLink(){
        if (!this.isEmptyObject(this.currentNode) && (this.selectedType === 'link')) {
          
          return {
            parent : this.currentNode.data.parent,
            pparent : this.currentNode.data.path,
            url : this.currentNode.data.url,
            description : this.currentNode.data.description,
            image : this.currentNode.data.image,
            text : this.currentNode.text,
            path: this.path,
          }
        }
        else {
          return {}
        }
      },*/
      selectedType() {
        if (!this.isEmptyObject(this.currentNode)) {
          return this.currentNode.data.type;
        } 
        else {
          return '';
        }
      },
    },
    mounted(){
      var tmp = [],
      tmppar = '';
      
    },
    methods: {
      isEmptyObject(a) {
        return $.isEmptyObject(a);
      },
      removeParent(){
        this.parent = 'ROOT';
      },
      //insert the new node in the js structure of the tree
      insert(obj, array){
        this.remakeTree = true;
        this.source.bookmarks.push(obj);
        let tree = this.find('bbn-tree');
        tree.reload();
        this.parent = 'ROOT'
        appui.success(obj.type === 'folder' ? bbn._('Folder') : bbn._('Link') + ' ' + bbn._('correctly inserted'))
        setTimeout(() => {
          this.remakeTree = false;
        }, 200);
      },
      edit(){
        if ( this.selectedType === 'link'){
          this.editing = true;
          this.showFormFolder = false;
          this.showFormLink = true;
          this.editing = true;
        }
        else if (this.selectedType === 'folder') {
         this.showFormFolder = true;
          this.showFormLink = false;
          this.editing = true;
        }
      },
      deleteFolder(){
        let st = bbn._('Are you sure you want to delete this folder');
        if (this.showFolder.items && this.showFolder.items.length ) {
          st += ' ' + bbn._('and all it\'s content?');
        }
        else{
          st += '?';
        }
        this.confirm(st, () => {
          this.remakeTree = true;
          bbn.fn.post('notes/actions/bookmarks/delete_folder', {folder: this.showFolder}, (d) => {
            if ( d.success ){
              
              this.source.bookmarks = d.bookmarks;
              
              setTimeout(() => {
                this.remakeTree = false;
              }, 200);
             
              this.parent = 'ROOT';
              this.showFolder = {};
              appui.success(bbn._("Folder successfully deleted"))
            }
            else {
              appui.error(bbn._('Something went wrong while deleting the folder'));
            }
          })
        })
      },
      deleteLink(){
        let obj = {
          text: this.currentNode.text,
          type: this.currentNode.data.type,
          url: this.currentNode.data.url,
          parent: this.currentNode.data.parent
          };
        this.remakeTree = true;
        this.confirm(bbn._('Are you sure you want to delete this link?'), ()=>{
          bbn.fn.post('notes/actions/bookmarks/delete_link', {
            obj: obj
          }, (d) => {
            if (d.success) {
              let idx = bbn.fn.search(this.source.bookmarks, obj);
              if (idx > -1) {
                this.source.bookmarks.splice(idx, 1);
              }
              setTimeout(() => {
                this.remakeTree = false;
              }, 200);
              this.currentNode = {};
              this.parent = 'ROOT';
              appui.success(bbn._("Link successfully deleted"))
            } else {
              appui.error(bbn._('Something went wrong while deleting the link'));
            }
          })
        })
      },
      showFormLinkM(){
        this.showFormFolder = false;
        this.showFormLink = true;
        this.showLink = {};
        this.editing = false;
      },
      showFormFolderM(){
        this.showFormFolder = true;
        this.showFormLink = false;
        this.showFolder = {};
        this.editing = false;
      },
      filterItems(text){
        let tmp = bbn.fn.filter(this.source.bookmarks, 'parent', text);
        if ( tmp.length ){
          
          bbn.fn.log('filter items', this.path)
          // IF I MISS DESCRIPTION AND URL ADD HERE!!
          return tmp.map( (a) => {
            return ({
              name: a.text ? a.text : a.url,
              text: a.text ? a.text : a.url,
              parent: a.parent, 
              type: a.type,
              url: a.type === 'folder' ? false : a.url,
              image: (( a.type === 'folder' ) || ( !a.image)) ? false : a.image,
              icon: a.type === 'folder' ? 'nf nf-fa-folder' : 'nf nf-fa-star',
              path: a.path ? a.path : false,
              num:  bbn.fn.count(
                this.source.bookmarks,
                'parent',
                a.text
              ),
              description: a.description ? a.description : '',
              items: this.filterItems(a.text)
            })
          })
        }
      },
      filter(a){
        let tmp = bbn.fn.map(
          bbn.fn.filter(
            this.source.bookmarks,
            'parent',
            a ? a.data.parent : 'ROOT'
          ), (b) => {
            b.num = bbn.fn.count(
              this.source.bookmarks,
              'parent',
              b.text
            );
            b.text = b.text ? b.text : b.url;
            b.name = b.text ? b.text : b.url;
            b.items = this.filterItems(b.text);
            b.icon = b.type === 'folder' ? 'nf nf-fa-folder' : 'nf nf-fa-star';
            b.url = b.type === 'folder' ? false : b.url;
            b.image = ((b.type === 'folder') || (!b.image)) ? false : b.image;
            b.description = b.description ? b.description : '';
            b.path = b.path ? b.path : false;
            return b;
          });
          this.realTreeSource.push(tmp);
        return this.source.bookmarks.length ? tmp : [];
      },

      select(a){
        if ( this.editing ){
          this.showFormLink = false;
          this.showFormFolder = false;
        }
        this.editing = false;
        

        this.currentNode = a;
        let tmp = a.getPath(),
          st = '';
        if (tmp.length) {
          bbn.fn.each(tmp, (v, i) => {
            st += v.name + '/'
          })
        }
        if ( a.data.type === 'folder' ){
          this.path = st;
          this.parent = a.text;
          this.showLink = {};
          this.selectedFolder(a);
        }
        if ( a.data.type === 'link' ){
          this.showLink = {
            parent: this.currentNode.data.parent,
            pparent: this.currentNode.data.path,
            url: this.currentNode.data.url,
            description: this.currentNode.data.description,
            image: this.currentNode.data.image,
            text: this.currentNode.text,
            path: this.path,
          };
          this.showFolder = {};
        }
        else if ( a.data.type === 'link' ||
          this.showFormFolder ) {
            this.showFolder = {};
            this.showFormLink = false;
            //this.showFormFolder = false;
          }
        else if ( ( a.level > 0) && (a.data.type === 'link')) {
          if ( a.closest('bbn-tree').$parent.data.type === 'folder' ) {
            st = st.slice(0, -(a.text.length + 1))
            this.path = st;
            this.parent = a.closest('bbn-tree').$parent.text;
          }
        }
        else{
          bbn.fn.log('select else')
          this.path = '/';
        }
      },
      selectedFolder(a){
        if ( a.text && a.data.parent ){
          //this.path += a.text;
          bbn.fn.log('selected folder', a, this.path)
          this.showFolder =  {
            text: a.text,
            parent: a.data.parent,
            type: 'folder'
          };
          if ( a.numChildren > 0 ){
            this.showFolder.items = a.items;
          }
          
          this.currentFolder = this.filterItems(a.text);
        }
      },
    },
    watch: {
      currentNode(val){
        bbn.fn.log('WATCH',val)  
      },
    }
  }
})();