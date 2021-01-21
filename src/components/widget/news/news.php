<div class="appui-note-widget-news">
  <div v-if="showForm">
    <bbn-form style="height: 500px"
              :buttons="[]"
              :fixedFooter="false"
              :source="formData"
              ref="form"
							:scrollable="false"
              :validation="validForm"
              :action="notesRoot + '/actions/insert'"
              @success="afterSubmit"
    >
      <div class="bbn-grid-fields" 
           style="margin-bottom: 10px; padding: 0"
      >
        <div><?=_('Title')?></div>
        <bbn-input v-model="formData.title"
                   required="required"
        ></bbn-input>
        <div><?=_("Pub. date")?></div>
        <bbn-datetimepicker v-model="formData.start"
                            required="required"
        ></bbn-datetimepicker>
        <div><?=_("End date")?></div>
        <bbn-datetimepicker v-model="formData.end"></bbn-datetimepicker>
        <!--<div class="bbn-c"
           style="margin-bottom: 10px"
      >
        <bbn-checkbox v-model="formData.private"
                      value="1"
                      novalue="0"
                      label="<i class='nf nf-fa-eye_slash'></i> <?/*=_('Private')*/?>"
                      style="margin-right: 2em"
        ></bbn-checkbox>
        <bbn-checkbox v-model="formData.locked"
                      value="1"
                      novalue="0"
                      label="<i class='nf nf-fa-lock'></i>  <?/*=_('Locked')*/?>"
        ></bbn-checkbox>
      </div>-->
      </div>
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
        <span v-text="shorten(item.title, 50)"
              :title="item.title"
              @click="openNote(item)"
              class="bbn-p"
              style="margin-left: 5px"
        ></span>
      </div>
    </ul>
  </div>
</div>
