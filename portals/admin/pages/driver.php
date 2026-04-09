<?php
/**
 * Admin Drivers Management Page (Legacy - Use drivers.php)
 * This page is maintained for backward compatibility
 * Redirect to modern drivers list
 */

require_once('../../../config/bootstrap.php');
require_once('login-security.php');

// Redirect to modern drivers page
header('Location: drivers.php', true, 301);
exit;
?>
                                                    <th>Status</th>
                                                    <th>Info</th>
                                                    <th>Action</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php getDrivers(); ?>

                                            </tbody>
                                        </table>

                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>

                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>


