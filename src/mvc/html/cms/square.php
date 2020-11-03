<!-- HTML Document -->
<div class="bbn-overlay appui-notes-square bbn-flex-height">
  <bbn-toolbar>
    <bbn-context :source="blockChoice">
      <bbn-button :notext="true"
                  icon="nf nf-fa-plus">
      </bbn-button>
    </bbn-context>
  </bbn-toolbar>
  <div class="bbn-flex-fill">
    <div class="bbn-100">
      <bbn-scroll>
        <div class="bbn-grid-fields"
             v-for="(line, i) in lines"
             tabindex="0"
             @click="focused = i">
          <div class="bbn-padded"
               style="width: 160px">
            <bbn-context :source="blockChoice">
              <bbn-button :notext="true"
                          icon="nf nf-fa-plus">
              </bbn-button>
            </bbn-context>
          </div>
          <div class="bbn-padded">
            <bbn-block :editable="focused === i"
                       :source="line">
            </bbn-block>
          </div>
        </div>
      </bbn-scroll>
    </div>
  </div>
</div>