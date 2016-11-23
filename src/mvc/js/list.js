// Javascript Document
$(".appui-notes-list", ele).kendoGrid({
  dataSource: {
    serverPaging: true,
    transport: {
      read: {
        url: data.root + "list",
        type: "post"
      }
    },
    schema: {
      data: "data",
      total: "total"
    },
  },
  columns: [{
    field: "title",
    title: "Titre",
    width: 300
  }, {
    field: "content",
    title: "Texte",
    encoded: false
  }, {
    field: "medias",
    title: "Medias",
    width: 100
  }],
  sortable: true,
  scrollable: true,
  pageable: {
    refresh: true,
    pageSize: 100
  }
});