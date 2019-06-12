<bbn-form :prefilled="true"
          :validation="folder"
          class="bookmarks-form-link"
          :buttons="[]"
>
  <div class="bbn-grid-fields info-container">
    <bbn-input class="bbn-grid-full" type="hidden" :value="parent"></bbn-input>
    <div class="bbn-grid-full">
      <i class="nf nf-fa-times bbn-p" v-if="parent !== 'ROOT'" @click="removeParent" title="<?=_("Create the link at root")?>"></i>
      <span class="bbn-green bbn-b" v-text="formHeader">
      </span>  
      
    </div>  
    <div>
      <span><?=_("Text")?></span>  
    </div>
    <div>
      <bbn-input ref="text"
                placeholder="<?=_("Link title")?>"
                class="bbn-w-100"
                v-model="source.text"
      ></bbn-input>
    </div>
    <div>
      <span><?=_("Description")?></span>      
    </div>
    <div>
      <bbn-textarea class="bbn-w-100"
                    style="width:100%"
                    v-model="source.description"
      ></bbn-textarea>
    
    </div>
    <div>
      <span><?=_("Url")?></span>
    </div>
    <div>
      <bbn-input ref="link"
                 @keydown.enter.prevent.stop="linkEnter" 
                 placeholder="<?=_("Type or paste your URL and press Enter to valid")?>"
                 class="bbn-w-100"
                 v-model="source.url"
                
      ></bbn-input>
    </div>          
    <div class="appui-notes-bookmarks-links-container bbn-widget bbn-grid-full"
         ref="linksContainer"
         v-if="source.image"
         :style="link  ? 'border:1px solid' : 'border:none'"
    >
      <div :class="['k-file', {
              'link-progress': source.image.inProgress && !source.image.error,
              'link-success': !source.image.inProgress && !source.image.error,
              'link-error': source.image.error
            }]"
      >
        <div class="bbn-flex-width">
          <div v-if="imageDom && source.image.image"
               class="appui-notes-bookmarks-link-image"
          >
            <img :src="imageDom + ( source.image.img_path ? source.image.img_path : ref ) + '/' + source.image.image"
            >
          </div>
           <div v-else class="appui-notes-bookmarks-link-noimage">
            <i class="nf nf-fa-link bbn-xl"></i>
          </div>
          <div class="appui-notes-bookmarks-link-title bbn-flex-fill">
            <strong>
              <a :href="source.image.content.url"
                  class="bbn-p"
                  v-text="source.image.content.url"
              ></a>
            </strong>
            <br>
            <span v-if="source.image.content && source.image.content.description"
                  v-text="source.image.content.description"
            ></span>
          </div>
          <div class="appui-notes-bookmarks-link-actions bbn-vmiddle">
            <bbn-button class="k-button-bare k-upload-action"
                        style="display: inline-block;"
                        @click="linkRemove"
                        icon="nf nf-fa-times"
                        title="<?=_('Remove')?>"
            ></bbn-button>
          </div>
        </div>
      </div>
    </div>
   
  </div>
  <div class="bbn-l bbn-padded">
    <bbn-button text="<?=_("Cancel")?>" 
                icon="nf nf-fa-times"
                @click="closeForm"
    >
    </bbn-button>
    <bbn-button text="<?=_("Save")?>" 
                icon="nf nf-fa-check"
                @click="submit"
    >
    </bbn-button>
  </div>
  
</bbn-form>