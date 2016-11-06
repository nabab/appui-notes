// Javascript Document
$(".appui-notes-list", ele).kendoGrid({
  dataSource: {
    transport: {
      read: {
        url: data.root + "data/notes/",
        type: "post",
        data: {
          json: 1
        }
      }
    },
    schema: {
      data: "data",
      total: "total"
    },
    pageSize:10
  },
  columns: [{
    field: "title",
    width: 300
  }, {
    field: "text",
    title: "Texte"
  }, {
    field: "medias",
    title: "Medias"
  }],
  sortable: true,
  scrollable: true,
});