// Javascript Document
(()=>{
  return{
    props: {
      'select': {
        default: false,
        type: Boolean
      }
    },
    data(){
      return {
        searchMedia: '',
        medias: [], 
        currentMedias: [],
        current:{},
        showList: false,
        selected: false,
      }
    },
    beforeMount(){
      this.post('notes/media/browser', {
        start: 0,
        limit: 150
      }, (d) => {
        this.medias = d.medias
        //need a copy of medias to manipulate it during the search 
        this.currentMedias = d.medias
      });
      if ( this.closest('bbn-router').selectingMedia ){
        this.select = true;
      }
    },
    computed: {
      extensions(){
        let res = [];
        bbn.fn.each(bbn.opt.extensions, (v, i) => {
          res.push(v.code.toLowerCase())
        })
        return res;
      }
    },
    methods: {
      editMedia(m, a){
        this.getPopup().open({
          title: bbn._('Edit media'),
          component: this.$options.components['form'],
          height: '400px',
          width: '400px',
          source: {
            media: m,
            edit: true,
            removedFile: false, 
            oldName: ''
          },
        })
      },
      addMedia(){
        this.getPopup().open({
          title: bbn._('Add new media'),
          component: this.$options.components['form'],
          height: '400px',
          width: '400px',
          source: {
            media: {
              title: '',
              file: [], 
              name: ''
        		}
          }
        })
      },
      formatBytes: bbn.fn.formatBytes,
      deleteMedia(m){
        this.confirm( m.notes.length ? bbn._('The media you\'re going to delete is linked to a note, are you sure you want to remove it?') : bbn._('Are you sure you want to delete this media?'),() => {
          this.post('notes/media/actions/delete', m, (d) => {
            if (d.success){
              let idx = bbn.fn.search(this.medias, 'id', m.id), 
                  cIdx = bbn.fn.search(this.currentMedias, 'id', m.id);
              if ( (idx > -1) && (cIdx > -1) ){
                this.medias.splice(idx, 1);
              }    
              appui.success(bbn._('Media successfully deleted :)'))
            }
            else{
              appui.error(bbn._('Something went wrong while deleting the media :('))
            }
          })
        })
      },
      showImage(img){
        this.getPopup().open({
          title: ' '/*img.name*/,
          source: img,
          content: '<div class="bbn-overlay bbn-middle"><img src="notes/media/image/' + img.id + '/' + img.content.path + '" style="max-width: 100%; max-height: 100%"></div>',
          height: '70%',
          width: '70%',
          scrollable: false
        })
      },
      showFileInfo(m){
        this.getPopup().open({
          title: m.title,
          source: m,
          component: this.$options.components['info'],
          height: 350,
          width: 400,
        })
      }
    },
    watch: {
      select(val){
        let rSelect = this.closest('bbn-router').selectingMedia
        if (!val && rSelect){
          delete(this.closest('bbn-router').selectingMedia )
        }
      },
      searchMedia(val){
        this.medias = bbn.fn.filter(this.currentMedias, (a) => {
          return a.title.toLowerCase().indexOf(val.toLowerCase()) > -1
        })
        
      }
    },
    components: {
      'form': {
        props: ['source'],
        template: `
<div class="bbn-padded">
	<bbn-form :validation="validation" :source="source" :data="{ref:ref}" :action="root + (source.edit ? 'media/actions/edit' : 'media/actions/save')" @success="success">
		<div class="bbn-grid-fields">
			<div>Title: </div>
			<bbn-input v-model="source.media.title" @blur="checkTitle"
								 :disabled="source.edit ? false : (!source.media.file.length ?true : false )"		
			></bbn-input>
			
			<div>Filename: </div>
			<bbn-input v-model="source.media.name"
								 :disabled="source.edit ? false : (!source.media.file.length ?true : false )"		
			></bbn-input>

			<div>Media: </div>
			<div>
				<bbn-upload v-if="source.edit"
										:json="true"
										v-model="content"
										:paste="true"
										:multiple="false"	
										:save-url="root + 'media/actions/upload_save/' + ref"
										@remove="setRemovedFile"
										:remove-url="root + 'media/actions/delete_file/'+ source.media.id"
				></bbn-upload>
				<bbn-upload v-model="source.media.file"
										v-else	
									  @success="uploadSuccess"
										:paste="true"
										:multi="false"	
										:save-url="root + 'media/actions/upload_save/' + ref"
				></bbn-upload></div>	
		</div>
	</bbn-form>
</div>`,
        data(){
          return {
            browser: {},
            root: appui.plugins['appui-notes'] + '/',     
            ref: (new Date()).getTime(),
            validTitle: true,
            content: [],
            //the idx of the media in medias of the container
            removedFile: false,
            mediaIdx:false
          }
        },
			  methods: {
          setRemovedFile(){
            this.source.removedFile = true
            this.removedFile = true
          },
          validation(a){
            if ( a.media.file && a.media.file[0] && a.media.file[0].extension ){
            	if (( a.media.name.indexOf(a.media.file[0].extension) > -1 ) &&
                  ( a.media.title.indexOf(a.media.file[0].extension) > -1 ) &&
                  ( a.media.name.replace(a.media.file[0].extension, '').length ) &&
                  ( a.media.name.replace(a.media.file[0].extension, '') !== '.' )
                 )
                {
                  return true;
              }
              
            }
            else if ( 
              a.media.content && a.media.content.extension && 
              ( a.media.name.indexOf(a.media.content.extension) > -1 ) &&
              ( a.media.title.indexOf(a.media.content.extension) > -1 ) &&
              ( a.media.name.replace(a.media.content.extension, '').length ) &&
              ( a.media.name.replace(a.media.content.extension, '') !== '.' )
             ){
              return true;
            }
            else{
              this.alert(bbn._('The extension in the title or in the filename doesn\'t match with the extension of the file you inserted!'))
              return false;
            }
          },
          uploadSuccess(){
            this.$nextTick(() => {
              if(this.source.media.file && this.source.media.file[0]){
                this.source.media.title = this.source.media.file[0].name
                this.source.media.name = this.source.media.file[0].name
              }
            })
          },
          setContent(){
            let res = [];
            if(this.source.edit){
              if ( bbn.fn.isObject(this.source.media.content)){
                this.source.media.content.name = this.source.media.name;
                res.push(this.source.media.content)
                this.content = JSON.stringify(res)
              }
            }
          },
         	checkTitle(){
            if ( this.source.media.title.indexOf('.') < 0 ){
              let extension = this.source.edit ? this.source.media.content.extension : this.source.media.file.extension
              if ( extension){
                this.source.media.title += '.' + this.source.media.content.extension
              }
              else{
                //CASE INSERT 
                this.validTitle = false;
                this.alert(bbn._('The title must contain the extension of the file'))
              }
            }
          },
          success(d){
            if(d.success && d.media){
              if ( !this.source.edit ){
                this.browser.medias.push(d.media);
                appui.success(bbn._('Media successfully added to media browser'));
              }
              else{
                this.browser.medias[this.mediaIdx].content['name'] = d.media.name
                if (d.media.is_image ){
                  this.browser.medias[this.mediaIdx].isImage = d.media.isImage
                }
                if ( this.removedFile ){
                  if(bbn.fn.isString(d.media.content)){
                    d.media.content = JSON.parse(d.media.content)
                  }
                  bbn.fn.log('before',this.mediaIdx)
                  let thatMediaIdx = this.mediaIdx
                  //the block has to disappear to show the new picture uploaded
                  this.browser.medias.splice(this.mediaIdx, 1);
                  setTimeout(() => {
                    this.browser.medias.splice(thatMediaIdx, 0, d.media);  
                    bbn.fn.log('after',thatMediaIdx, d.media, JSON.stringify(d.media))
                  }, 50);
                }	  
                appui.success(bbn._('Media successfully updated'));
              }
            }
            else{
              appui.error(bbn._('Something went wrong while adding the media to the media broser'))
            }
          }
        },
        mounted(){
          this.browser = this.closest('bbn-container').find('appui-notes-media-browser')
          this.mediaIdx =  bbn.fn.search(this.browser.medias, 'id', this.source.media.id);
          this.setContent();
          this.source.edit ? (this.source.oldName = this.source.media.content.name) : ''
        },
        watch: {
          content(val, oldVal){
            if(val){
              let tmp = JSON.parse(val)
              if(tmp[0]){
                this.source.media.content = tmp[0];
              }
            }
          }
        }
      },
      'info': {
          template: 
`
<div>
	<div class="bbn-grid-fields bbn-padded">
		<div>Title:</div>
		<div v-text="source.title"></div>
		<div>Filename:</div>
		<div v-text="source.name"></div>
		<div>Type:</div>
		<div v-text="source.type"></div>
		<div>User:</div>
		<div v-text="get_field(users, 'value', source.id_user, 'text')"></div>
		<div>Size:</div>
    <div v-text="formatBytes(source.content.size)"></div>
    <div>Extension:</div>
    <div v-text="source.content.extension"></div>
    <div class="bbn-grid-full bbn-bordered" v-for="n in source.notes">
      <div class="bbn-grid-fields">
        <div>Note title:</div>
        <div v-text="n.title"></div>
        <div>Creation:</div>
        <div v-text="n.creation"></div>
        <div>Version:</div>
        <div v-text="n.version"></div>
				<div>Published:</div>
        <div v-text="n.is_published ? _('Yes') : _('No') "></div>
        <div>Content:</div>
        <i class="nf nf-mdi-comment_text bbn-medium bbn-p" title="Note content" @click="show_note_content(n)"></i>
      </div>    
    </div>
  </div>
</div>
`,
        props: ['source'],
        data(){
          return {
            users: appui.app.users
          }
        },
        methods: {
          show_note_content(n){
            this.getPopup().open({
              title: n.title,
              content: n.content
            })
          },
          formatBytes: bbn.fn.formatBytes,
          get_field: bbn.fn.get_field,
        }
      }, 
      'block': {
        template: '#block', 
        props: ['source', 'data'],
        data(){
          return {
            icons: {
               pdf: 'nf nf-fa-file_pdf_o', 
               docx: 'nf nf-mdi-file_document', 
               xls: 'nf nf-fa-file_excel_o', 
               odt: 'nf nf-mdi-file_word', 
            },
            cp: {},
            adjustTop: '',
            adjustWidth: '',
            canShow: false,
            editinline:false,
            initialTitle: '',
            root: 'notes/media',
            select: '', 
            removedFile: false,
          }
        },
        computed: {
          isMobile: bbn.fn.isMobile,
          cutted(){
            if(this.data.media.title.length > 20){
              return this.data.media.title.substr(0,20);
            }
            return this.data.media.title;
          },
        },
        methods:{
          routeClick(m){
            if ( this.select ){
              this.addMediaToNote(m);
            }
            else{
              if(m.is_image){
                this.cp.showImage(m)
              }
            }
          },
          addMediaToNote(m){
            this.closest('appui-notes-media-browser').selected = m;
            this.closest('appui-notes-media-browser').$emit('select',m)
          },
          showFileInfo(m){
            this.closest('appui-notes-media-browser').showFileInfo(m)
          },
          editMedia(m){
            this.closest('appui-notes-media-browser').editMedia(m, this.dataIdx)
          },
          deleteMedia(m){
            this.closest('bbn-container').getComponent().deleteMedia(m)
          },
          focusInput(){
            this.$nextTick(()=>{
              this.find('bbn-input').focus()
            })
          },
          adjustTitle(){
            if ( this.data.media.title.indexOf('.') < 0 ){
              if ( this.data.media.content.extension ){
                this.data.media.title += '.' + this.data.media.content.extension;
                return true;
              }
              else{
                //CASE INSERT 
                this.validTitle = false;
                this.data.media.title = this.initialTitle;
                this.alert(bbn._('The title must contain the extension of the file'))
                return false;
              }
            }
            return false;
          },
          
          //change the title inline and exit from edit mode
          exitEdit(){
            this.editinline = false;
            if( this.data.media.title !== this.initialTitle ){
              let title = this.data.media.title,
              	ext_title = title.substr(title.lastIndexOf('.') + 1, title.length - 1 );
       			  if ( ext_title === this.data.media.content.extension ){
                this.post('notes/media/actions/edit_title', {
                  id: this.data.media.id, 
                  title: this.data.media.title, 
                }, (d) => {
                  if ( d.success ){
                    this.initialTitle = this.data.media.title;
                    appui.success(bbn._('Media title successfully changed!'))
                  }
                  else {
                    appui.error(bbn._('Something went wrong while changing the media title'))
                  }
                })
              }
              else {
                this.data.media.title = this.initialTitle
                this.alert(bbn._('The title must end with the same extension of the file'))
              }       
            }
       
          }                   	
    
          		
        },
        mounted(){
          this.cp = this.closest('appui-notes-media-browser');
          this.select = this.cp.select
          this.initialTitle = this.data.media.title
          this.data.media.removedFile = false;
        },
        watch: {
          isMobile(val){
            if(!val){
          //    this.find('bbn-context').showFloater = false;
            }
          },
          editinline(val){
            if(val){
              this.$nextTick( ()=>{
                if(this.adjustTitle()){
                  this.find('bbn-input').focus();
                }
							})  
            }
          }
        }
      },
      'list': {
        template: `
<bbn-list :source="btns"
           class="media-floating-list bbn-bordered"
           >
 </bbn-list>
`,
        props: ['source','data'],
        data(){
          return{
            mediaIdx: false, 
            //at mounted know if browser is open in selecting mode
            select: false
          }
        },
        computed :{
          btns(){
            let res = [{
             icon: 'nf nf-fa-info', 
             title: 'Get more info', //bbn._('Get more info'),
             action: () => {
               this.showFileInfo(this.data.media)
             	}, 
             }, {
             icon: 'nf nf-fa-edit',
             title: bbn._('Edit media'),
             action: () => {
             	 this.editMedia(this.data.media)      
             }
             }, {
             icon: 'nf nf-fa-trash_o',
             title: bbn._('Delete media'),
             action: () => {
             	 this.deleteMedia(this.data.media)      
             }
             }];
            return res;
          },
        },
       	methods:{
          showFileInfo(m){
            this.closest('appui-notes-media-browser').showFileInfo(m)
          },
          editMedia(m){
            this.closest('appui-notes-media-browser').editMedia(m)
          },
          deleteMedia(m){
            this.closest('appui-notes-media-browser').deleteMedia(m)
          }
        },
        mounted(){
          if ( this.closest('appui-notes-media-browser').select ){
            this.closest('appui-notes-media-browser').selected = false
          }
          if (this.data.media.id){
            this.mediaIdx = bbn.fn.search(this.closest('appui-notes-media-browser').medias, 'id', this.data.media.id)
          }
        }
      }
      
    }
  }
})();