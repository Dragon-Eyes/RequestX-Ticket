                <form action="<?php echo 'details?key=' . $key . '&action=comnew'; ?>" method="post"<?php if(FEATURE_ATTACHMENTS) { echo ' enctype="multipart/form-data"'; } ?>>
                    <fieldset style="background-color: #dddddd;">
                        <h2>Neuer Kommentar <?php if(FEATURE_ATTACHMENTS) { echo ' und / oder Anhang'; } ?></h2>
                        <dl>
                            <dt>Kommentar</dt>
                            <dd>
                                <textarea name="comment" rows="2" cols="60" autofocus></textarea>
                            </dd>
                        </dl>
                        <?php if(FEATURE_ATTACHMENTS) { ?>
                        <dl>
                            <dt>Anhang</dt>
                            <dd>
                                <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                                <input type="file" name="attachment" id="attachment" accept="image/*">
                            </dd>
                        </dl>
                        <?php } ?>
                            <input type="hidden" name="followers" value="<?php echo implode(',', $request['followers']) ?>">
                        <div style="display: block; clear: left; padding: 30px 0 30px 165px;" id="operations">
                            <input type="submit" value="Speichern">
                        </div>
                    </fieldset>
				</form>
