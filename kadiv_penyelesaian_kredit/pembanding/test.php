<th width="18%">
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="respon_pil4_2b" form="my_form" name="respon_pil4_2b" cols="35" rows="12"><?= $respon4['respon_pil4_2b'] ?></textarea>
                                            </th>
                                            <th width="18%">
                                                <center>SKMR</center>
                                                <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_respon4['respon_pil4_2b'] ?></textarea>
                                                <center>SKAI</center>
                                                <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skai_respon4['respon_pil4_2b'] ?></textarea>
                                            </th>
                                            <th> 
                                                <center>FINAL</center>
                                                <select class="form-select" id="kpmr_pil4_2b" form="my_form" name="kpmr_pil4_2b">
                                                    <option <?= $pil4['pilar4_2b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_2b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil4['pilar4_2b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil4['pilar4_2b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil4['pilar4_2b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil4['pilar4_2b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select>
                                                <center>SKMR</center>
                                                <select class="form-select"  form="my_form"  style="pointer-events: none;">
                                                    <option <?= $div_skmr_pil4['pilar4_2b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $div_skmr_pil4['pilar4_2b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $div_skmr_pil4['pilar4_2b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $div_skmr_pil4['pilar4_2b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $div_skmr_pil4['pilar4_2b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $div_skmr_pil4['pilar4_2b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select>
                                                <center>SKAI</center>
                                                <select class="form-select"  form="my_form"  style="pointer-events: none;">
                                                    <option <?= $div_skai_pil4['pilar4_2b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $div_skai_pil4['pilar4_2b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $div_skai_pil4['pilar4_2b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $div_skai_pil4['pilar4_2b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $div_skai_pil4['pilar4_2b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $div_skai_pil4['pilar4_2b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select>
                                               
                                            </th>

                                            <td  colspan="2">
                                            </td>