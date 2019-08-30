(()=>{
  return {
    data(){
      return {     
        root: appui.plugins['appui-notes'] + '/',     
      }
    },
    methods:{
      renderUrl(row){
        if ( row.url !== null ){
          return '<a href="' +row.url +'">'+row.url+'</a>';
        }
        return '-';
      },
      renderDate(row){
        return moment(row.post_date).format('DD/MM/YYYY HH:mm');
      },
      renderDateModified(row){
        return moment(row.post_modified).format('DD/MM/YYYY HH:mm');
      },
      renderDateGmt(row){
        return moment(row.post_date_gmt).format('DD/MM/YYYY HH:mm');
      }
    }    
  }
})();