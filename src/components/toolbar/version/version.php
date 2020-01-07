<div class="bbn-header bbn-spadded bbn-vmiddle">
  <div class="bbn-flex-width">
    <div class="bbn-flex-fill">
      <span><?=_('Version')?>: </span>
      <span v-text="currentVersion"></span>
      <span class="bbn-hsmargin">|</span>  
      <span v-text="currentDate"></span>
      <span class="bbn-hsmargin">|</span>
      <span v-text="currentCreator"></span>
    </div>
    <div v-if="hasVersions">
      <span><?=_('Versions')?>: </span>
      <bbn-dropdown :source="dataUrl"
                    :data="{
                      id: data.id
                    }"
                    v-model="currentVersion"
                    :map="map"
      ></bbn-dropdown>
    </div>
  </div>
</div>