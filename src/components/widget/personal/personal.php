<div class="appui-notes-widget-personal">
  <div v-if="showForm">
    <bbn-form style="height: 500px"
              :buttons="[]"
              :fixedFooter="false"
              :source="formData"
              ref="form"
							:scrollable="false"
              action="notes/actions/insert"
              @success="afterSubmit"
    >
      <bbn-input v-model="formData.title"
                 placeholder="<?=_('Title')?>"
                 style="margin-bottom: 10px; width: 100%"
      ></bbn-input>
      <!--<div class="bbn-c"
           style="margin-bottom: 10px"
      >
        <bbn-checkbox v-model="formData.postit"
                      value="1"
                      novalue="0"
                      label="<i class='nf nf-fa-eye_slash'></i> <?/*=_('Post-it')*/?>"
        ></bbn-checkbox>
      </div>-->
      <div class="bbn-w-100" style="width: 100%; height: 400px">
					<bbn-rte v-model="formData.content"
	                 required="required"
									 height="100%"
	        ></bbn-rte>
      </div>
      <div class="bbn-w-100 bbn-r"
					 style="margin-top: 20px"
		  >
        <bbn-button style="margin-right:0.5em"
                    @click="$refs.form.submit()"
										icon="nf nf-fa-save"
        ><?=_('Add')?></bbn-button>
        <bbn-button @click="closeForm"
										icon="nf nf-fa-times"
				><?=_('Cancel')?></bbn-button>
      </div>

    </bbn-form>
  </div>
  <div v-else>
    <ul>
      <div v-for="item in source.items"
           style="padding: 0.4em 0.6em"
           class="bbn-vmiddle"
      >
        <bbn-initial width="20"
                     height="20"
                     :user-id="item.id_user"
                     :title="userName(item.id_user)"
        ></bbn-initial>
        <span v-if="shorten(item.title, 50)"
              v-text="item.title"
              title="item.title"
              @click="openNote(item)"
              class="bbn-p"
              style="margin-left: 5px"
        ></span>
        <span v-else
              v-text="html2text(shorten(item.content, 50))"
              @click="openNote(item)"
              class="bbn-p"
              style="margin-left: 5px"
        ></span>
      </div>
    </ul>
  </div>
</div>
