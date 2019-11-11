                <form action="<?php echo 'details?key=' . $key . '&action=comnew'; ?>" method="post"<?php if(FEATURE_ATTACHMENTS) { echo ' enctype="multipart/form-data"'; } ?>>
                    <fieldset style="background-color: #dddddd;">
                        <h2><?php echo $_SESSION['copy']['commentNew']; if(FEATURE_ATTACHMENTS) { echo ' ' . $_SESSION['copy']['andorAttachment']; } ?></h2>
                        <dl>
                            <dt><?php echo $_SESSION['copy']['comment']; ?></dt>
                            <dd>
                                <textarea name="comment" rows="2" cols="60" autofocus></textarea>
                            </dd>
                        </dl>
                        <?php if(FEATURE_ATTACHMENTS) { ?>
                        <dl>
                            <dt><?php echo $_SESSION['copy']['attachment']; ?></dt>
                            <dd>
                                <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                                <input type="file" name="attachment" id="attachment" accept="image/*">
                            </dd>
                        </dl>
                                <input type="hidden" name="followers" value="<?php echo implode(',', $request['followers']) ?>">
                        <?php } ?>
                        <div style="display: block; clear: left; padding: 30px 0 30px 165px;" id="operations">
                            <input type="submit" value="<?php echo $_SESSION['copy']['save']; ?>">
                        </div>
                    </fieldset>
				</form>
