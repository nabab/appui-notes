<!-- HTML Document -->
<div class="bbn-overlay bookmarks-container">
  <bbn-splitter orientation="horizontal">
    <bbn-pane size="50%"
    >
			<div class="bbn-100">
        <div class="bbn-padded button-container">
          <bbn-button icon="nf nf-fa-star" 
                      class="bbn-padded star"  
                      @click="showFormLinkM" 
                      title="<?=_('New bookmark')?>"
                      text="<?=_('New bookmark')?>"
                      ></bbn-button>
          <bbn-button icon="nf nf-fa-folder_plus" 
                      class="bbn-padded"  
                      @click="showFormFolderM" 
                      title="<?=_('New folder')?>"
                      text="<?=_('New folder')?>"
          ></bbn-button>
        </div>
        <div class="bbn-100">
          <bbn-tree v-if="!remakeTree"
                    :source="filter"
                    @select="select"
                    class="bbn-medium"
          ></bbn-tree>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane>
      <appui-notes-bookmarks-link v-if="showFormLink && !showFormFolder" :source="showLink"
      ></appui-notes-bookmarks-link>
      <appui-notes-bookmarks-folder v-else-if="showFormFolder && !showFormLink" :source="showFolder"
      ></appui-notes-bookmarks-folder>
      <!--appui-notes-bookmarks-list v-else-if="currentNode && (selectedType === 'folder') && !showFormFolder && !showFormLink">
      </appui-notes-bookmarks-list-->
      <appui-notes-bookmarks-show v-else-if="(showLink.text || showFolder.text) && !showFormFolder && !showFormLink"
                                  :source="{showLink: showLink,showFolder:showFolder}"
      >
      </appui-notes-bookmarks-show>


    </bbn-pane>
  </bbn-splitter>
  
  <!--appui-notes-bookmarks-booksform></appui-notes-bookmarks-booksform-->
</div>