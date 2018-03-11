<bbn-table :source="source.root + 'news'"
           :pageable="true"
           ref="table"
           :info="true"
           :limit="10"
           :toolbar="[{
             text: '<?=_('New message')?>',
             icon: 'fa fa-plus',
             command: insert
           }]"
           :editable="true"
           :editor="$options.components['appui-notes-news-new']"
           :data="{
             type: source.type,
             root: source.root
           }"
>
  <bbn-column :hidden="true"
              field="id_note"
              :editable="false"
  ></bbn-column>
  <bbn-column field="title"
              title="<i class='fa fa-newspaper-o bbn-xl'></i>"
              ftitle="<?=_("Title")?>"
  ></bbn-column>
  <bbn-column field="id_user"
              title="<i class='fa fa-user bbn-xl'></i>"
              ftitle="<?=_("Author")?>"
              :width="300"
              :render="rendertAuthor"
  ></bbn-column>
  <bbn-column field="content"
              title="<i class='fa fa-comment bbn-xl'></i>"
              ftitle="<?=_("Text")?>"
              :hidden="true"
  ></bbn-column>
  <bbn-column field="creation"
              title="<i class='fa fa-calendar bbn-xl'></i>"
              ftitle="<?=_("Creation date")?>"
              :width="120"
              type="date"
              cls="bbn-c"
  ></bbn-column>
  <bbn-column :width="100"
              ftitle="<?=_("Actions")?>"
              :buttons="[{
                command: see,
                icon: 'fa fa-eye',
                text: '<?=_("See")?>',
                notext: true
              }, {
                command: edit,
                icon: 'fa fa-edit',
                text: '<?=_("Mod.")?>',
                notext: true
              }]"
  ></bbn-column>
</bbn-table>


<script type="text/x-template" id="appui-notes-news-new">
  <bbn-form class="bbn-full-screen"
            :source="source.row"
            :data="source.data"
            ref="form"
            :action="source.data.root + 'actions/' + ( source.row.id_note ? 'update' : 'insert')"
            @success="success"
  >
    <div class="bbn-padded bbn-grid-fields">
      <label>
        <?=_("Titre")?>
      </label>
      <bbn-input required="required"
                 v-model="source.row.title"
      ></bbn-input>
      <label>
        <?=_("Text")?>
      </label>
      <div>
        <bbn-rte v-model="source.row.content"
                 required="required"
        ></bbn-rte>
      </div>
    </div>
  </bbn-form>
</script>