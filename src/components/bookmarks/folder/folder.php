<bbn-form :prefilled="true"
          :validation="folder"
          class="bbn-padded"
          :buttons="[]"
          >
  <div class="bbn-padded bbn-grid-fields">
    <div class="bbn-grid-full">
      <i class="fas fa-times bbn-p" v-if="parent !== 'ROOT'" @click="removeParent" title="<?=_("Create the link at root")?>"></i> 
      <span class="bbn-green bbn-b" v-text="( parent !== 'ROOT' ) ? '<?=_('Create the folder in')?>' +  ' ' + path : '<?=_('Create the folder at root or select a folder from the tree')?>'"></span>   
               
    </div>
    <div class="bbn-padded">
      <span><?=_("New folder")?></span>
    </div>  
    <div class="bbn-padded">
      <bbn-input v-model="text"
                 @keydown.enter.prevent.stop="submit"" 
      ></bbn-input>
    </div>
    <bbn-input type="hidden" :value="parent"></bbn-input>
  </div>
  <div class="bbn-l bbn-padded">
    <bbn-button text="<?=_("Cancel")?>" 
                icon="fas fa-times"
                @click="closeForm"
    >
    </bbn-button>
    <bbn-button text="<?=_("Create folder")?>" 
                icon="fas fa-check"
                @click="submit"
    >
    </bbn-button>
  </div>
</bbn-form>