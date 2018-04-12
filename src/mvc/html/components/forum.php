<div class="bbn-full-screen appui-notes-forum">
	<div class="bbn-full-screen bbn-flex-height">
		<div v-if="toolbar"
				 class="k-header bbn-w-100"
				 ref="toolbar"
				 style="min-height: 30px"
		>
		<!-- toolbar -->
			<div v-if="toolbarButtons.length" class="bbn-spadded">
				<bbn-button v-for="(button, i) in toolbarButtons"
										class="bbn-hsmargin"
										:key="i"
										v-bind="button"
										@click="_execCommand(button, i)"
				></bbn-button>
			</div>
			<div v-else-if="typeof(toolbar) === 'function'"
					 v-html="toolbar()"
			></div>
			<component v-else
								 :is="toolbar"
			></component>
		</div>
		<!-- Main -->
		<div class="bbn-w-100 bbn-flex-fill">
			<bbn-scroll>
				<div v-for="(d, i) in currentData"
						 :key="i"
             class="bbn-w-100"
				>
          <div :class="['bbn-flex-width', 'k-widget', {'k-alt': !!(i%2)}]">
            <div class="bbn-spadded">
              <bbn-initial :user-id="d.creator"></bbn-initial>
            </div>
            <div class="bbn-flex-fill bbn-spadded"
                 v-html="d.content"
            ></div>
            <div v-if="d.creator === currentUser()"
                 class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                 style="margin-left: 1rem"
                 title="<?=_('Actions')?>"
            >
              <i class="fa fa-ellipsis-h bbn-xl bbn-p"></i>
            </div>
            <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                 style="margin-left: 1rem"
                 title="<?=_('Reply')?>"
            >
              <i class="fa fa-reply bbn-xl bbn-p"
								 @click="reply ? reply(d) : false"
							></i>
            </div>
            <div class="bbn-spadded bbn-hmargin bbn-vmiddle bbn-p appui-notes-forum-hfixed"
                 title="<?=_('Replies')?>"
                 @click="toggleReplies(d)"
            >
              <i class="fa fa-comments-o bbn-xl"></i>
              <span :class="['w3-badge', {'w3-red': !d.num_replies, 'w3-green': d.num_replies}]"
                    v-text="d.num_replies"
                    style="margin-left: 5px"
              ></span>
            </div>
            <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                 :title="'<?=_('Created')?>: ' + fdate(d.creation) + ((d.creation !== d.last_edit) ? ('\n<?=_('Edited')?>: ' + fdate(d.last_edit)) : '')"
            >
              <i v-if="d.creation !== d.last_edit"
                 class="fa fa-calendar-check-o bbn-xl"
              ></i>
              <i v-else
                 class="fa fa-calendar-o bbn-xl"
              ></i>
              <div class="bbn-c bbn-s">
                <div v-text="(d.creation !== d.last_edit) ? sdate(d.last_edit) : sdate(d.creation)"></div>
                <div v-text="(d.creation !== d.last_edit) ? hour(d.last_edit) : hour(d.creation)"></div>
              </div>
            </div>
          </div>
					<!-- Replies -->
          <div v-if="d.showReplies"
               class="bbn-w-100"
          >
            <div v-if="!d.replies"
                 class="bbn-middle bbn-padded"
            ><?=_('LOADING')?>...</div>
            <div v-else>
              <div v-for="(r, k) in d.replies"
                   :key="k"
                   :class="['bbn-flex-width', 'k-widget', 'appui-notes-forum-replies', {'k-alt': !!(k%2)}]"
              >
                <div class="bbn-spadded">
                  <bbn-initial :user-id="r.creator"></bbn-initial>
                </div>
                <div class="bbn-flex-fill bbn-spadded"
                >
                  <div v-if="r.id_parent !== r.id_alias"
                       class="bbn-vmiddle"
                  >
                    <i class="fa fa-reply bbn-large icon-flip"></i>
                    <bbn-initial :user-id="r.parent_creator"
                                 :height="20"
                                 class="bbn-hsmargin"
                    ></bbn-initial>
                    <i class="fa fa-calendar-o bbn-large"></i>
                    <span v-text="fdate(r.parent_creation)"></span>
                  </div>
                  <div v-html="r.content"></div>
                </div>
                <div v-if="r.creator === currentUser()"
                     class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                     style="margin-left: 1rem"
                     title="<?=_('Actions')?>"
                >
                  <bbn-context class="fa fa-ellipsis-h bbn-xl bbn-p"
                               tabindex="-1"
                               tag="i"
                               :source="[{
                                 icon: 'fa fa-edit',
                                 text: '<?=_('Edit')?>'
                               }, {
                                 icon: 'fa fa-trash',
                                 text: '<?=_('Delete')?>'
                               }]"
                  ></bbn-context>
                </div>
                <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                     style="margin-left: 1rem"
                     title="<?=_('Reply')?>"
                >
                  <i class="fa fa-reply bbn-xl bbn-p"
										 @click="reply ? reply(r) : false"
									></i>
                </div>
                <div v-if="r.num_replies"
                     class="bbn-spadded bbn-hmargin bbn-vmiddle appui-notes-forum-hfixed"
                     title="<?=_('Replies')?>"
                >
                  <i class="fa fa-comments-o bbn-xl"></i>
                  <span class="w3-badge w3-green"
                        v-text="r.num_replies"
                        style="margin-left: 5px"
                  ></span>
                </div>
                <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                     :title="'<?=_('Created')?>: ' + fdate(r.creation) + ((r.creation !== r.last_edit) ? ('\n<?=_('Edited')?>: ' + fdate(r.last_edit)) : '')"
                >
                  <i v-if="r.creation !== r.last_edit"
                     class="fa fa-calendar-check-o bbn-xl"
                  ></i>
                  <i v-else
                     class="fa fa-calendar-o bbn-xl"
                  ></i>
                  <div class="bbn-c bbn-s">
                    <div v-text="(r.creation !== r.last_edit) ? sdate(r.last_edit) : sdate(r.creation)"></div>
                    <div v-text="(r.creation !== r.last_edit) ? hour(r.last_edit) : hour(r.creation)"></div>
                  </div>
                </div>
              </div>
            </div>
						<!-- Replies footer -->
						<appui-notes-forum-pager inline-template
																		 :source="d"
																		 :ajax-url="isAjax ? source : null"
																		 :map="map"
																		 :data="{id_alias: d.id}"
						>
							<div class="appui-notes-forum-pager k-widget k-floatwrap appui-notes-forum-replies"
									 v-if="pageable || isAjax"
							>
								<div class="bbn-block"
										 v-if="pageable"
								>
									<bbn-button icon="fa fa-angle-double-left"
															:notext="true"
															title="<?=_('Go to the first page')?>"
															:disabled="isLoading || (currentPage == 1)"
															@click="currentPage = 1"
									></bbn-button>
									<bbn-button icon="fa fa-angle-left"
															:notext="true"
															title="<?=_('Go to the previous page')?>"
															:disabled="isLoading || (currentPage == 1)"
															@click="currentPage--"
									></bbn-button>
									<?=_('Page')?>
									<bbn-numeric v-if="source.replies && source.replies.length"
															 v-model="currentPage"
															 :min="1"
															 :max="numPages"
															 style="margin-right: 0.5em; width: 6em"
															 :disabled="isLoading"
									></bbn-numeric>
									<?=_('de')?> {{numPages}}
									<bbn-button icon="fa fa-angle-right"
															:notext="true"
															title="<?=_('Go to the next page')?>"
															:disabled="isLoading || (currentPage == numPages)"
															@click="currentPage++"
									></bbn-button>
									<bbn-button icon="fa fa-angle-double-right"
															:notext="true"
															title="<?=_('Go to the last page')?>"
															@click="currentPage = numPages"
															:disabled="isLoading || (currentPage == numPages)"
									></bbn-button>
									<span class="k-pager-sizes k-label">
										<bbn-dropdown :source="limits"
																	v-model.number="currentLimit"
																	@change="currentPage = 1"
																	:disabled="!!isLoading"
										></bbn-dropdown>
										<span><?=_('articles par page')?></span>
									</span>
								</div>
								<div class="bbn-block" style="float: right">
									<span v-if="pageable"
												v-text="_('Display items') + ' ' + (start+1) + '-' + (start + currentLimit > total ? total : start + currentLimit) + ' ' + _('of') + ' ' + total"
									></span>
									<span v-else
												v-text="total ? _('Total') + ': ' + total + ' ' + _('items') : _('No item')"
									></span>
									&nbsp;
									<bbn-button v-if="isAjax"
															title="<?=_('Refresh')?>"
															@click="updateData"
															icon="fa fa-refresh"
									></bbn-button>
								</div>
							</div>
						</appui-notes-forum-pager>
          </div>
				</div>
			</bbn-scroll>
		</div>
		<!-- Footer -->
		<div class="appui-notes-forum-pager k-widget k-floatwrap"
         v-if="pageable || filterable || isAjax"
    >
      <div class="bbn-block"
           v-if="pageable"
      >
        <bbn-button icon="fa fa-angle-double-left"
                    :notext="true"
                    title="<?=_('Go to the first page')?>"
                    :disabled="isLoading || (currentPage == 1)"
                    @click="currentPage = 1"
        ></bbn-button>
        <bbn-button icon="fa fa-angle-left"
                    :notext="true"
                    title="<?=_('Go to the previous page')?>"
                    :disabled="isLoading || (currentPage == 1)"
                    @click="currentPage--"
        ></bbn-button>
        <?=_('Page')?>
        <bbn-numeric v-if="currentData.length"
                     v-model="currentPage"
                     :min="1"
                     :max="numPages"
                     style="margin-right: 0.5em; width: 6em"
                     :disabled="isLoading"
        ></bbn-numeric>
        <?=_('de')?> {{numPages}}
        <bbn-button icon="fa fa-angle-right"
                    :notext="true"
                    title="<?=_('Go to the next page')?>"
                    :disabled="isLoading || (currentPage == numPages)"
                    @click="currentPage++"
        ></bbn-button>
        <bbn-button icon="fa fa-angle-double-right"
                    :notext="true"
                    title="<?=_('Go to the last page')?>"
                    @click="currentPage = numPages"
                    :disabled="isLoading || (currentPage == numPages)"
        ></bbn-button>
        <span class="k-pager-sizes k-label">
          <bbn-dropdown :source="limits"
                        v-model.number="currentLimit"
                        @change="currentPage = 1"
                        :disabled="!!isLoading"
          ></bbn-dropdown>
          <span><?=_('articles par page')?></span>
        </span>
      </div>
      <div class="bbn-block" style="float: right">
        <span v-if="pageable"
              v-text="_('Display items') + ' ' + (start+1) + '-' + (start + currentLimit > total ? total : start + currentLimit) + ' ' + _('of') + ' ' + total"
        ></span>
        <span v-else
              v-text="total ? _('Total') + ': ' + total + ' ' + _('items') : _('No item')"
        ></span>
        &nbsp;
        <bbn-button v-if="filterable"
                    :disabled="!isChanged"
                    title="<?=_('Reset to original configuration')?>"
                    @click="reset"
                    icon="zmdi zmdi-time-restore-setting"
        ></bbn-button>
        <bbn-button v-if="isAjax"
                    title="<?=_('Refresh')?>"
                    @click="updateData"
                    icon="fa fa-refresh"
        ></bbn-button>
      </div>
    </div>
	</div>
</div>
