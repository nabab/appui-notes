<!-- HTML Document -->
<div class="bbn-overlay appui-notes-square bbn-flex-height">
  <bbn-toolbar class="bbn-spadded">
    <control :source="blockChoice"/>
  </bbn-toolbar>
  <div class="bbn-flex-fill">
    <div class="bbn-100">
      <bbn-scroll>
        <div class="bbn-grid-fields"
             v-for="(line, i) in lines"
             tabindex="0">
          <div class="bbn-padded"
               style="width: 160px">
            <control :source="blockChoice" :index="i"/>
          </div>
          <div class="bbn-padded">
            <bbn-cms-block :source="line"
                       ref="block"
                       :index="i"
                       v-if="line.type"
            >
            </bbn-cms-block>
            <span v-else class="bbn-c bbn-medium bbn-green"><?=('Select a block type')?></span>
          </div>
        </div>
      </bbn-scroll>
    </div>
  </div>
</div>