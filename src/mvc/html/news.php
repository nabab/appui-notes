<bbn-table :source="source.root + 'data/news'"
           :pageable="true"
           ref="table"
           :info="true"
           :limit="10"
           :toolbar="[{
             text: '<?=_('New message')?>',
             icon: 'fas fa-plus',
             command: insert
           }]"
           :editable="true"
           :editor="$options.components['appui-notes-news-new']"
           :data="{
             type: source.type,
             root: source.root
           }"
>
  <bbns-column :hidden="true"
              field="id_note"
              :editable="false"
  ></bbns-column>
  <bbns-column field="title"
              title="<i class='far fa-newspaper bbn-xl'></i>"
              ftitle="<?=_("Title")?>"
  ></bbns-column>
  <bbns-column field="id_user"
              title="<i class='fas fa-user bbn-xl'></i>"
              ftitle="<?=_("Author")?>"
              :width="300"
              :render="rendertAuthor"
  ></bbns-column>
  <bbns-column field="content"
              title="<i class='fas fa-comment bbn-xl'></i>"
              ftitle="<?=_("Text")?>"
              :hidden="true"
  ></bbns-column>
  <bbns-column field="creation"
              title="<i class='fas fa-calendar-alt bbn-xl'></i>"
              ftitle="<?=_("Creation date")?>"
              :width="120"
              type="date"
              cls="bbn-c"
  ></bbns-column>
  <bbns-column :width="100"
              cls="bbn-c"
              ftitle="<?=_("Actions")?>"
              :buttons="[{
                command: see,
                icon: 'fas fa-eye',
                text: '<?=_("See")?>',
                notext: true
              }, {
                command: edit,
                icon: 'fas fa-edit',
                text: '<?=_("Mod.")?>',
                notext: true
              }]"
  ></bbns-column>
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