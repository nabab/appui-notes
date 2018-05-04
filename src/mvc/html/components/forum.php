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
										@click="_execCommand(button)"
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
			<bbn-scroll v-if="!isLoading">
        <appui-notes-forum-topic inline-template
                                 v-for="(d, i) in currentData"
                                 :key="i"
                                 class="bbn-w-100"
                                 :source="d"
        >
          <div class="bbn-w-100">
            <div :class="['bbn-flex-width', 'k-widget', 'appui-notes-forum-topic', {'k-alt': !!($vnode.key%2)}]">
              <div class="bbn-spadded">
                <bbn-initial :user-id="source.creator"></bbn-initial>
              </div>
              <div class="bbn-flex-fill bbn-spadded"
              >
                <div v-if="source.title"
                     v-text="source.title"
                     class="bbn-b"
                ></div>
                <div v-html="source.content"></div>
                <div v-if="source.links && source.links.length">
                  <fieldset class="k-widget">
                    <legend><?=_("Links:")?></legend>
                    <div v-for="l in source.links"
                         style="margin-top: 10px"
                    >
                      <div class="bbn-flex-width"
                           style="margin-left: 0.5em"
                      >
                        <div style="height: 96px">
                          <img v-if="l.name && l.id && forum.imageDom"
                               :src="forum.imageDom + l.id + '/' + l.name"
                          >
                          <i v-else class="fa fa-link"></i>
                        </div>
                        <div class="appui-notes-forum-link-title bbn-flex-fill bbn-vmiddle">
                          <div>
                            <strong>
                              <a :href="l.content.url"
                                 v-text="l.title || l.content.url"
                                 target="_blank"
                              ></a>
                            </strong>
                            <br>
                            <a v-if="l.title"
                               :href="l.content.url"
                               v-text="l.content.url"
                               target="_blank"
                            ></a>
                            <br v-if="l.title">
                            <span v-if="l.content.description"
                                  v-text="l.content.description"
                            ></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
                <div v-if="source.files && source.files.length">
                  <fieldset class="k-widget">
                    <legend><?=_("Files:")?></legend>
                    <div v-for="f in source.files">
                      <span style="margin-left: 0.5em"
                            :title="f.title"
                      >
                        <a class="media bbn-p"
                           @click="downloadMedia(f.id)"
                        >
                          <i class="fa fa-download" style="margin-right: 5px"></i>
                          <span v-text="f.name"></span>
                        </a>
                      </span>
                    </div>
                  </fieldset>
                </div>
              </div>
              <div v-if="source.creator === forum.currentUser"
                   class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                   style="margin-left: 1rem"
                   title="<?=_('Actions')?>"
              >
                <bbn-context class="fa fa-ellipsis-h bbn-xl bbn-p"
                             tabindex="-1"
                             tag="i"
                             :source="[{
                               icon: 'fa fa-edit',
                               text: '<?=_('Edit')?>',
                               command: () => {forum.edit(source, _self)}
                             }, {
                               icon: 'fa fa-trash',
                               text: '<?=_('Delete')?>',
                               command: () => {forum.remove(source, _self)}
                             }]"
                ></bbn-context>
              </div>
              <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                   style="margin-left: 1rem"
                   title="<?=_('Reply')?>"
              >
                <i class="fa fa-reply bbn-xl bbn-p"
                   @click="forum.reply ? forum.reply(source, _self) : false"
                ></i>
              </div>
              <div class="bbn-spadded bbn-hmargin bbn-vmiddle bbn-p appui-notes-forum-hfixed"
                   title="<?=_('Replies')?>"
                   @click="toggleReplies()"
              >
                <i class="fa fa-comments-o bbn-xl"></i>
                <span :class="['w3-badge', {'w3-red': !source.num_replies, 'w3-green': source.num_replies}]"
                      v-text="source.num_replies || 0"
                      style="margin-left: 5px"
                ></span>
              </div>
              <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                   :title="'<?=_('Created')?>: ' + forum.fdate(source.creation) + ((source.creation !== source.last_edit) ? ('\n<?=_('Edited')?>: ' + forum.fdate(source.last_edit)) : '')"
              >
                <i v-if="source.creation !== source.last_edit"
                   class="fa fa-calendar-check-o bbn-xl bbn-orange"
                ></i>
                <i v-else
                   class="fa fa-calendar-o bbn-xl"
                ></i>
                <div class="bbn-c bbn-s">
                  <div v-text="(source.creation !== source.last_edit) ? forum.sdate(source.last_edit) : forum.sdate(source.creation)"></div>
                  <div v-text="(source.creation !== source.last_edit) ? forum.hour(source.last_edit) : forum.hour(source.creation)"></div>
                </div>
              </div>
            </div>
            <!-- Replies -->
            <div v-if="showReplies"
                 class="bbn-w-100"
            >
              <div v-if="!source.replies"
                   class="bbn-middle bbn-padded"
              ><?=_('LOADING')?>...</div>
              <div v-else>
                <appui-notes-forum-post inline-template
                                        v-for="(r, k) in source.replies"
                                        :source="r"
                                        :key="k"
                >
                  <div :class="['bbn-flex-width', 'k-widget', 'appui-notes-forum-replies', {'k-alt': !!($vnode.key%2)}]">
                    <div class="bbn-spadded">
                      <bbn-initial :user-id="source.creator"></bbn-initial>
                    </div>
                    <div class="bbn-flex-fill bbn-spadded"
                    >
                      <div v-if="source.id_parent !== source.id_alias"
                           class="bbn-vmiddle"
                      >
                        <i class="fa fa-reply bbn-large icon-flip"></i>
                        <bbn-initial :user-id="source.parent_creator"
                                     :height="20"
                                     class="bbn-hsmargin"
                        ></bbn-initial>
                        <i class="fa fa-calendar-o bbn-large"></i>
                        <span v-text="topic.forum.fdate(source.parent_creation)"
                              :style="{textDecoration: !source.parent_active ? 'line-through' : 'none'}"
                              class="bbn-s"
                        ></span>
                        <span v-if="!source.parent_active"
                              class="bbn-hsmargin bbn-i bbn-s"
                        ><?=_('deleted')?></span>
                      </div>
                      <div v-html="source.content"></div>
                      <div v-if="source.links.length">
                        <fieldset class="k-widget">
                          <legend><?=_("Links:")?></legend>
                          <div v-for="l in source.links"
                               style="margin-top: 10px"
                          >
                            <div class="bbn-flex-width"
                                 style="margin-left: 0.5em"
                            >
                              <div style="height: 96px">
                                <img v-if="l.name && topic.forum.imageDom"
                                     :src="topic.forum.imageDom + l.id + '/' + l.name"
                                >
                                <i v-else class="fa fa-link"></i>
                              </div>
                              <div class="appui-notes-forum-link-title bbn-flex-fill bbn-vmiddle">
                                <div>
                                  <strong>
                                    <a :href="l.content.url"
                                       v-text="l.title || l.content.url"
                                       target="_blank"
                                    ></a>
                                  </strong>
                                  <br>
                                  <a v-if="l.title"
                                     :href="l.content.url"
                                     v-text="l.content.url"
                                     target="_blank"
                                  ></a>
                                  <br v-if="l.title">
                                  <span v-if="l.content.description"
                                        v-text="l.content.description"
                                  ></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </fieldset>
                      </div>
                      <div v-if="source.files.length">
                        <fieldset class="k-widget">
                          <legend><?=_("Files:")?></legend>
                          <div v-for="f in source.files">
                            <span style="margin-left: 0.5em"
                                  :title="f.title"
                            >
                              <a class="media bbn-p"
                                 @click="topic.forum.downloadMedia(f.id)"
                              >
                                <i class="fa fa-download" style="margin-right: 5px"></i>
                                <span v-text="f.name"></span>
                              </a>
                            </span>
                          </div>
                        </fieldset>
                      </div>
                    </div>
                    <div v-if="source.creator === topic.forum.currentUser"
                         class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                         style="margin-left: 1rem"
                         title="<?=_('Actions')?>"
                    >
                      <bbn-context class="fa fa-ellipsis-h bbn-xl bbn-p"
                                   tabindex="-1"
                                   tag="i"
                                   :source="[{
                                     icon: 'fa fa-edit',
                                     text: '<?=_('Edit')?>',
                                     command: () => {topic.forum.edit(source, _self)}
                                   }, {
                                     icon: 'fa fa-trash',
                                     text: '<?=_('Delete')?>',
                                     command: () => {topic.forum.remove(source, _self)}
                                   }]"
                      ></bbn-context>
                    </div>
                    <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                         style="margin-left: 1rem"
                         title="<?=_('Reply')?>"
                    >
                      <i class="fa fa-reply bbn-xl bbn-p"
                         @click="topic.forum.reply ? topic.forum.reply(source, _self) : false"
                      ></i>
                    </div>
                    <div v-if="source.num_replies"
                         class="bbn-spadded bbn-hmargin bbn-vmiddle appui-notes-forum-hfixed"
                         title="<?=_('Replies')?>"
                    >
                      <i class="fa fa-comments-o bbn-xl"></i>
                      <span class="w3-badge w3-green"
                            v-text="source.num_replies"
                            style="margin-left: 5px"
                      ></span>
                    </div>
                    <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                         :title="'<?=_('Created')?>: ' + topic.forum.fdate(source.creation) + ((source.creation !== source.last_edit) ? ('\n<?=_('Edited')?>: ' + topic.forum.fdate(source.last_edit)) : '')"
                    >
                      <i v-if="source.creation !== source.last_edit"
                         class="fa fa-calendar-check-o bbn-xl bbn-orange"
                      ></i>
                      <i v-else
                         class="fa fa-calendar-o bbn-xl"
                      ></i>
                      <div class="bbn-c bbn-s">
                        <div v-text="(source.creation !== source.last_edit) ? topic.forum.sdate(source.last_edit) : topic.forum.sdate(source.creation)"></div>
                        <div v-text="(source.creation !== source.last_edit) ? topic.forum.hour(source.last_edit) : topic.forum.hour(source.creation)"></div>
                      </div>
                    </div>
                  </div>
                </appui-notes-forum-post>
              </div>
              <!-- Replies footer -->
              <appui-notes-forum-pager inline-template
                                       :source="source"
                                       :key="'appui-notes-forum-pager-' + $vnode.key"
                                       ref="pager"
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
        </appui-notes-forum-topic>
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
