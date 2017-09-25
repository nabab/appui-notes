<bbn-table class="bbn-w-100"
           ref="table"
           source="notes/table_notes"
           :limit="25"
           :info="true"
           :pageable="true"
           :sortable="true"
           :filterable="true"
           :editable="true"
           :toolbar="[{
                     text: 'Nouvel note',
                     icon: 'fa fa-plus',
                     notext: false,
                     command: insert
                     }]"
           :order="[{field: 'creation', dir: 'DESC'}]"
           :expander="$options.components['apst-notes-content']"
           :editor="$options.components['apst-new-note']"
>
  <bbn-column field="id_note"
              hidden="true"
  ></bbn-column>

  <bbn-column field="creator"
              title="<?=_("Creator")?>"
              :render="creator"
              :width="160"
              class="bbn-c"
  ></bbn-column>

  <bbn-column field="id_user"
              title="<?=_("Last version user")?>"
              :render="last_mod_user"
              :width="160"
              class="bbn-c"
  ></bbn-column>

  <bbn-column field="creation"
              title="<?=_("Creation")?>"
              type="date"
              class="bbn-c"
              :width="120"
  ></bbn-column>
  
  <bbn-column field="version"
              title="<?=_("Version")?>"
              :width="70"
              class="bbn-c"
  ></bbn-column>

  <bbn-column field="title"
              title="<?=_("Title")?>"
              :render="title"
              class="bbn-c"
  ></bbn-column>

  <bbn-column :width="160"
              title="<?=_("Actions")?>"
              :render="title"
              :buttons="[{text:'Markdown', command: markdown}, {text:'RichTextEditor', command: rte}]"
  ></bbn-column>

</bbn-table>

<script type="text/x-template" id="apst-notes-content">
  <div style="height: 300px; margin-right:30px; position:relative">
    <input type="hidden" :value="source.id_notes">
    <div  v-html="source.content ? source.content : 'no content'" style="height:100%;
    width:100%"></div>
  </div>
</script>

<script type="text/x-template" id="apst-new-note">
  <bbn-form :data="source"
            ref="form"
            confirm-leave="<?=_("Êtes-vous sûr de vouloir quitter ce formulaire sans enregistrer vos modifications?")?>"
            :action="'adherent/actions/notes/' + ( source.id ? 'update' : 'insert')"
            :buttons="['submit', 'cancel', 'close']"
            @success="success"
            @failure="failure"
>
    <div class="bbn-padded bbn-w-100" style="min-height: 500px">


      <label class="bbn-form-label" >
        <?=_("Catégorie")?>
      </label>
      <div class="bbn-form-field">
        <bbn-dropdown name="id_type_note"
                      required="required"
                      v-model="source.id_type_note"
                      :source="options.notes"
        ></bbn-dropdown>
      </div>

      <label class="bbn-form-label">
        <?=_("Texte")?>
      </label>
      <div class="bbn-form-field"
           v-bbn-fill-height
      >
        <bbn-rte v-model="source.texte"
                 name="texte"
                 required="required"
                 class="bbn-100"
        >
        </bbn-rte>
      </div>

      <label class="bbn-form-label" v-if="isOwner">
        <?=_("Bloqué")?>
      </label>
      <div class="bbn-form-field" v-if="isOwner">
        <bbn-checkbox v-model="source.confidentiel"
                      name="confidentiel"
                      id="t4Wo9nnuXZb4wXifPahWB"
                      :checked="source.confidentiel ? true : false"
        ></bbn-checkbox>
      </div>
    </div>
  </bbn-form>
</script>