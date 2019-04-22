<div class="bbn-full-screen book-bottom" 
    
>
  <div class="bbn-w-100 bbn-padded">
    <bbn-button class="bbn-p"
                icon="nf nf-fa-trash "
                title="<?=_("Delete this link")?>"
                @click="remove"
                :text="'<?=_("Delete this")?>' + ' ' + selectedType"
    ></bbn-button>
    <bbn-button class="bbn-p"
                icon="nf nf-fa-edit "
                title="<?=_("Edit this link")?>"
                @click="edit"
                :text="'<?=_("Edit this")?>' + ' ' + selectedType"
    ></bbn-button>
  </div>
  
  <div v-if="selectedType === 'link'" class="bbn-grid-fields">
    <span v-if="source.showLink.path" 
        class="bbn-green bbn-medium"
    ><?=_("Path")?></span>
    <div v-if="source.showLink.path"
        class="bbn-green bbn-medium"
        v-text="(source.showLink.path !== '/') ? source.showLink.path : 'Root'"
    ></div>

    <span v-if="source.showLink.text"
          class="bbn-medium"
    ><?=_("Text")?></span>
    <div v-if="source.showLink.text"
        v-text="source.showLink.text"
        class="bbn-medium"
    ></div>
    

    <span v-if="source.showLink.url"
          class="bbn-medium"
    ><?=_("Url")?></span>
    <div class="bbn-medium">
      <a :src="renderUrl(source.showLink.url)" v-text="renderUrl(source.showLink.url)" class="bbn-p bbn-medium"></a>
    </div>

    <span v-if="source.showLink.description"
          class="bbn-medium"
    ><?=_("Description")?></span>
    <div v-if="source.showLink.description" 
        v-text="source.showLink.description ? source.showLink.description : '' "
        class="bbn-medium"     
    ></div>

    <div class="appui-notes-bookmarks-links-container k-widget bbn-grid-full"
          ref="linksContainer"
          v-if="source.showLink.image"
          style="border:1px solid"
    >
      <div :class="['k-file', {
              'link-progress': source.showLink.image.inProgress && !source.showLink.image.error,
              'link-success': !source.showLink.image.inProgress && !source.showLink.image.error,
              'link-error': source.showLink.image.error
            }]"
      >
        <div class="bbn-flex-width">
          <div v-if="source.showLink.image.img_path && source.showLink.image.image"
              class="appui-notes-bookmarks-link-image">
            <img :src="imageDom + source.showLink.image.img_path + source.showLink.image.image"
            >
          </div>
          <div v-else class="appui-notes-bookmarks-link-noimage">
            <i class="nf nf-fa-link bbn-xl"></i>
          </div>
          <div class="appui-notes-bookmarks-link-title bbn-flex-fill">
            <strong>
              <a :href="source.showLink.image.content.url"
                  class="bbn-p"
                  v-text="source.showLink.image.title || source.showLink.image.content.url"
              ></a>
            </strong>
            <br>
            <span v-if="source.showLink.image.content && source.showLink.image.content.description"
                  v-text="source.showLink.image.content.description"
            ></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div v-else-if="source.showFolder" class="bbn-grid-fields bbn-medium">
    <span v-if="source.showFolder.items && source.showFolder.items.length" 
          v-html="'The folder contains' + ' ' +'<span class=\'bbn-green\'>' + source.showFolder.items.length + 'items' + '</span>' "
          class="bbn-grid-full"
    ></span>
    <span v-else 
          class="bbn-grid-full"
    ><?=_("This folder is empty")?></span>
    <span><?=_("Folder name")?></span>
    <span v-text="source.showFolder.text"></span>
    
    <span><?=_("Parent")?></span>
    <span v-text="source.showFolder.parent"></span>
  </div>
</div>