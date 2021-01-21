<!-- HTML Document -->
<div class="bbn-overlay appui-note-cms">
  <bbn-table ref="table"
             :source="source.root + 'cms/list'"
             :columns="cols"
             :limit="25"
             :info="true"
             :pageable="true"
             :sortable="true"
             :filterable="false"
  					 :toolbar="$options.components['toolbar']"
  ></bbn-table>
</div>

<script type="text/x-template" id="toolbar">
  <bbn-toolbar class="bbn-header bbn-hspadded bbn-h-100 bg-fuxia">
    <div class="bbn-flex-width">
      <bbn-button icon="nf nf-fa-plus"
                  :text="_('Insert Articles')"
                  :action="insertNote"
      ></bbn-button>
      
      <div class="bbn-xl bbn-b bbn-flex-fill bbn-r">
        <?=_("Cms management")?>
      </div>
    </div>
  </bbn-toolbar>
</script>

<!--form for create new pge in note-->
<script type="text/x-template" id="form">
  <bbn-form ref="form"
            :action="url"
            :source="source"
            @success="afterSubmit"
            :data="{publish: publish}"
            :validation="validationForm"
            :prefilled="true"
  >
    <div class="bbn-overlay">
      <div class="bbn-grid-fields bbn-lpadded">
        <label class="bbn-b">
          <?=_('Title')?>
        </label>
        <bbn-input v-model="source.title"
                   required="required"
                   class="bbn-w-50"
                   @change="makeURL"
                   :required="true"
                   :readonly="source.action === 'publish'"
        ></bbn-input>
     
        <label class="bbn-b">
          <?=_('Publish')?>
        </label>
        <bbn-checkbox :value="true"
                      v-model="publish"
                      :novalue="false"
        ></bbn-checkbox>
        <label class="bbn-b" v-if="publish">
          <?=_('Pub. date')?>
        </label>
        <bbn-datetimepicker v-model="source.start"
                            class="bbn-w-20"
                            :nullable="true"
                            v-if="publish"
        ></bbn-datetimepicker>
        <label v-if="publish"
               class="bbn-b"
               v-text="_('End date') + ':'"
        ></label>
        <bbn-datetimepicker v-model="source.end"
                            class="bbn-w-20"
                            :min="source.start ? source.start : '' "
                            :nullable="true"
                            v-if="publish"
        ></bbn-datetimepicker>

        <label class="bbn-b"
               v-text="_('Url') + ':'"
        ></label>
        <bbn-input v-model="source.url"
                   class="bbn-w-100"
                   :readonly="source.action === 'publish'"
                   @keydown="adjustURL"
                   :required="true"
        ></bbn-input>
        <label v-text="_('Add media from gallery:')"
               class="bbn-b"
               >
  			</label>
        <div>
          <bbn-button icon="nf nf-mdi-attachment"
                      class="bbn-xl"
                      :notext="true"
                      @click="addMedia"
                      :title="_('Add a media from the media browser')"
          ></bbn-button>
  			</div>
				<div class="bbn-grid-full" v-if="source.files && source.files.length">
          <appui-note-media-preview v-for="(f, i) in source.files" 
                                     :data="f"
                                     :key="i"
          ></appui-note-media-preview>
        </div>
      </div>
      <div style="height:350px;" class="bbn-spadded">
        <bbn-rte v-model="source.content"
                 required="required"
                 style="height:350px;"
                 :iframe="true"
                 :readonly="source.action === 'publish'"
        ></bbn-rte>
      </div>
    </div>
  </bbn-form>
</script>