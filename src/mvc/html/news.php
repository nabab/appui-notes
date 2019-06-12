<bbn-table :source="source.root + 'data/news'"
           :pageable="true"
           ref="table"
           :info="true"
           :limit="25"
           :toolbar="[{
             text: '<?=_('New message')?>',
             icon: 'nf nf-fa-plus',
             command: insert
           }]"
           :editable="true"
           :editor="$options.components['appui-notes-news-new']"
           :data="{
             type: source.type
           }"
           :filterable="true"
>
  <bbns-column :hidden="true"
               field="id_note"
               :editable="false"
               :filterable="false"
  ></bbns-column>
  <bbns-column field="title"
               title="<i class='nf nf-fa-newspaper bbn-xl'></i>"
               ftitle="<?=_("Title")?>"
  ></bbns-column>
  <bbns-column field="id_user"
               title="<i class='nf nf-fa-user bbn-xl'></i>"
               ftitle="<?=_("Author")?>"
               :width="300"
               :source="users"
  ></bbns-column>
  <bbns-column field="content"
               title="<i class='nf nf-fa-comment bbn-xl'></i>"
               ftitle="<?=_("Text")?>"
               :hidden="true"
  ></bbns-column>
  <bbns-column field="creation"
               title="<i class='nf nf-fa-calendar_alt bbn-xl'></i>"
               ftitle="<?=_("Creation date")?>"
               :width="120"
               type="date"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column field="start"
               title="<i class='nf nf-fa-calendar_check bbn-xl'></i>"
               ftitle="<?=_("Start date")?>"
               :width="120"
               type="date"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column field="end"
               title="<i class='nf nf-fa-calendar_times bbn-xl'></i>"
               ftitle="<?=_("End date")?>"
               :width="120"
               type="date"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column :width="100"
               cls="bbn-c"
               ftitle="<?=_("Actions")?>"
               :buttons="[{
                 command: see,
                 icon: 'nf nf-fa-eye',
                 text: '<?=_("See")?>',
                 notext: true
               }, {
                 command: edit,
                 icon: 'nf nf-fa-edit',
                 text: '<?=_("Mod.")?>',
                 notext: true
               }]"
               :filterable="false"
  ></bbns-column>
</bbn-table>


<script type="text/x-template" id="appui-notes-news-new">
  <bbn-form
            :source="source.row"
            :data="source.data"
            ref="form"
            :action="root + '/actions/' + ( source.row.id_note ? 'update' : 'insert')"
            @success="success"
  >
    <div class="bbn-grid-fields">
      <label>
        <?=_("Title")?>
      </label>
      <bbn-input required="required"
                 v-model="source.row.title"
      ></bbn-input>
      <label>
        <?=_("Publication date")?>
      </label>
      <div>
        <bbn-datetimepicker v-model="source.row.start"
                            required="required"
        ></bbn-datetimepicker>
      </div>
      <label>
        <?=_("End date")?>
      </label>
      <div>
        <bbn-datetimepicker v-model="source.row.end"></bbn-datetimepicker>
      </div>
      <label>
        <?=_("Text")?>
      </label>
      <div style="overflow: inherit; height: 500px">
        <bbn-rte v-model="source.row.content"
                 required="required"
        ></bbn-rte>
      </div>
    </div>
  </bbn-form>
</script>