<bbn-form class="bbn-full-screen appui-notes-forum-form"
          :action="source.props.formAction"
          :source="source.row"
					:data="data"
          @success="source.props.formSuccess"
>
  <div class="bbn-grid-fields bbn-padded">
    <label v-if="source.row.title !== undefined"><?=_("Title")?></label>
    <bbn-input v-if="source.row.title !== undefined"
							 v-model="source.row.title"
	  ></bbn-input>

    <label v-if="(source.row.category !== undefined) && source.props.categories"><?=_("Category")?></label>
    <bbn-dropdown v-if="(source.row.category !== undefined) && source.props.categories"
                  :required="source.props.showCategories"
                  v-model="source.row.category"
                  :source="source.props.categories"
    ></bbn-dropdown>

    <div style="text-align: right">
      <div><?=_("Text")?></div>
      <!--<br>
      <bbn-dropdown :source="editorTypes"
                    ref="editorType"
                    @change="switchEditorType"
      ></bbn-dropdown>-->
    </div>
    <div>
      <component :is="editorType"
                 ref="editor"
                 v-model="source.row.text"
                 style="min-height: 200px; width: 100%;"
								 required="required"
      ></component>
    </div>

    <label v-if="fileSave && fileRemove"><?=_("Files")?></label>
    <div v-if="fileSave && fileRemove"
         class="bbn-task-files-container">
      <bbn-upload :save-url="fileSave + data.ref"
                  :remove-url="fileRemove + data.ref"
									v-model="source.row.files"
      ></bbn-upload>
    </div>

    <label><?=_("Links")?></label>
    <div>
      <div>
        <bbn-input ref="link"
                   @keydown.enter.prevent.stop="linkEnter"
                   placeholder="<?=_("Type or paste your URL and press Enter to valid")?>"
                   class="bbn-w-100"
        ></bbn-input>
      </div>
      <div class="appui-notes-forum-links-container k-widget"
           ref="linksContainer"
           v-if="source.row.links"
      >
        <div v-for="(l, idx) in source.row.links"
             :class="['k-file', {
               'link-progress': l.inProgress && !l.error,
               'link-success': !l.inProgress && !l.error,
               'link-error': l.error
             }]"
        >
          <div class="bbn-flex-width">
            <div v-if="imageDom"
                 class="appui-notes-forum-link-image">
              <img v-if="l.image"
                   :src="imageDom + data.ref + '/' + l.image"
              >
              <i v-else class="fas fa-link"> </i>
            </div>
            <div class="appui-notes-forum-link-title bbn-flex-fill">
              <strong>
                <a :href="l.content.url"
                   v-text="l.title || l.content.url"
                ></a>
              </strong>
              <br>
              <span v-if="l.content && l.content.description"
                    v-text="l.content.description"
              ></span>
            </div>
            <div class="appui-notes-forum-link-actions bbn-vmiddle">
              <bbn-button class="k-button-bare k-upload-action"
                          style="display: inline-block;"
                          @click="linkRemove(idx)"
                          icon="fas fa-times"
                          title="<?=_('Remove')?>"
              ></bbn-button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <label><?=_("Locked")?></label>
    <div>
      <bbn-checkbox v-model="source.row.locked"
                    :value="1"
                    :novalue="0"
      ></bbn-checkbox>
    </div>
  </div>
</bbn-form>
