(() => {
  return{
    data(){
      return {
        url: '',
        text: '',
        description: '', 
        link: false,
        linkPreview: 'notes/actions/bookmarks/link_preview',
        imageDom: bookmarks.imageDom,
      }
    },
    mounted(){
      if ( this.source ){
        this.url = this.source.url;
        this.text = this.source.text;
        this.description = this.source.description;
        this.link = this.source.image;
      }
    },
    computed: {
      formHeader(){
        if ( !this.editing ){
          if (this.parent !== 'ROOT') {
            return bbn._('Insert the link in the folder') + ' ' + this.path;
          } else {
            return bbn._('Insert the link in the folder') + ' ' + this.parent;
          }
        }
        else { 
          return bbn._('Edit this link');
        }
      },
      remakeTree() {
        return bookmarks.remakeTree;
      },
      ref(){
        return moment().unix();
      },
      path() {
        return bookmarks.path;
      },
      parent(){
        return bookmarks.parent;
      },
      editing() {
        return bookmarks.editing;
      },
    },
    methods: {
      closeForm(){
        bookmarks.showFormLink = false;
      },
      removeParent(){
        bookmarks.removeParent();
      },
      editLink(){
        this.confirm(bbn._('Are you sure you want to save changes?'),() => {
          bbn.fn.post('notes/bookmarks/actions/edit', this.source, (d) => {
            if ( d.success && d.bookmarks){
              bookmarks.source.bookmarks = d.bookmarks;  
            }
          })
        })
        alert('edit')
      },
      submit(){
        if ( !this.editing ) {
          bbn.fn.log('SUBMIT', bookmarks.parent)
          
          let object = {
              parent: this.parent.length ? this.parent : 'ROOT',
              description: this.source.description,
              url: this.source.url,
              text: this.source.text,
              type: 'link',
              link: this.source.image ? this.source.image : false
            },
            obj = {
              parent: this.parent.length ? this.parent : 'ROOT',
              url: this.url,
              text: this.source.text ? this.source.text : this.source.url,
              type: 'link',
              icon: 'far fa-star',
              description: this.source.description,
              image: this.source.image ? this.source.image : false
            }
          bbn.fn.post('notes/actions/bookmarks/insert', object, (d) => {
            if (d.success > 0) {
              //bookmarks.source.bookmarks = d.bookmarks;
              //this.description = '';
              //this.url = '';
              //this.text = '';
              bookmarks.parent = 'ROOT';
              bookmarks.showFormLink = false;
              //bookmarks.source.bookmarks = d.bookmarks;
              bookmarks.insert(obj, d.bookmarks);
            } else {
              appui.error(d.error);
            }
          });
        }
        else {
          this.editLink(object);
        }
      },
      linkEnter() {
        const url = (this.$refs.link.$refs.element.value.indexOf('http') !== 0 ? 'http://' : '') +
          this.$refs.link.$refs.element.value;
        if (this.linkPreview) {
          this.link = {
            inProgress: true,
            content: {
              url: url,
              description: this.description
            },
            image: false,
            title: false,
            error: false
          };
          bbn.fn.post(this.linkPreview, {
            url: url,
            ref: this.ref
          }, (d) => {
            if (d.data && d.data.realurl) {
              if (d.data.picture) {
                this.link.image = d.data.picture;
              }
              if (d.data.title) {
                this.link.title = d.data.title;
              }
              if (d.data.desc) {
                this.link.content.description = d.data.desc;
              }
              if (d.data.img_path) {
                this.link.img_path = d.data.img_path;
              }
              this.link.inProgress = false;
              this.$refs.link.$refs.element.value = '';
            } 
            else {
              this.link.error = true;
            }
          });
        }
      },
      linkRemove() {
        this.confirm(bbn._('Are you sure you want to remove this link?'), () => {
          this.link = false;
        });
      },
      folder(){
        return (!bookmarks.selectedType || (bookmarks.selectedType === 'folder')) ? true : false;
      },
    }
  }
})();