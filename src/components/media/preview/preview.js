// Javascript Document
(()=>{
  return{
    props: ['source', 'data'],
    data(){
      return {
        icons: {
          pdf: 'nf nf-fa-file_pdf_o', 
          docx: 'nf nf-mdi-file_document', 
          xls: 'nf nf-fa-file_excel_o', 
          odt: 'nf nf-mdi-file_word', 
        },
        initialTitle: '',
      }
    },
    computed: {
      cutted(){
        if(this.data.title.length > 20){
          return this.data.title.substr(0,20);
        }
        return this.data.title;
      },
    },
    methods: {
      //make a post to take the content of the img??
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
    }
  }
})();