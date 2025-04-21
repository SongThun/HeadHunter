<?php include __DIR__ . '/../../utils.php'; ?>

<div class="container my-3">
    <!-- New job post section -->
    <section class="mb-5">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold title">New job posts</h2>
            <a href="<?= BASE_URL ?>/jobposts/" class="view-all-button">
                View all
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-arrow-right ms-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M0 8a.5.5 0 0 1 .5-.5h12.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H0.5A.5.5 0 0 1 0 8" />
                </svg>
            </a>
        </div>
        <!-- Job posts container-->
        <div class="job-posts d-flex p-2">
            <?php if (empty($data['latestPosts'])): ?>
                <p>No job posts to see.</p>
            <?php else: ?>
                <?php foreach ($data['latestPosts'] as $post): ?>
                    <!-- A single post -->
                    <div class="job-post" onclick="viewJobPost(<?= htmlspecialchars($post['ID']) ?>)" style="cursor: pointer;">
                        <div class="row align-items-start mb-3">
                            <!-- Company logo -->
                            <div class="col-auto">
                                <?php if (empty($post['Avatar'])): ?>
                                    <img src="https://placehold.co/69x69" alt="Company logo" class="company-logo">
                                <?php else: ?>
                                    <img src="<?= htmlspecialchars(UPLOAD_IMG . $post['Avatar']) ?>"
                                        alt="<?= htmlspecialchars($post['Company']) ?> logo" width="69" height="69"
                                        class="company-logo">
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <!-- Company name -->
                                <p class="company-name fw-bold mb-2"><?= htmlspecialchars($post['Company']) ?></p>
                                <!-- Submit day -->
                                <p class="submit-day mb-2">Submit <?= formatDate($post['CreatedDate']) ?></p>
                                <!-- Job position -->
                                <p class="job-position fw-bold pt-1 pb-2"><?= htmlspecialchars($post['Postname']) ?></p>
                                <!-- Due day -->
                                <p class="due-day pb-0">Due date: <?= formatDate($post['Due']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- New application section -->
    <section>
        <!-- Title and View all button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold title">New applications</h2>
            <a href="<?= BASE_URL ?>/applications/" class="view-all-button">
                View all
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-arrow-right ms-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M0 8a.5.5 0 0 1 .5-.5h12.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H0.5A.5.5 0 0 1 0 8" />
                </svg>
            </a>
        </div>
        <!-- Application container -->
        <div class="applications p-3">
            <?php if (empty($data['recentApp'])): ?>
                <p>No recent applications found.</p>
            <?php else: ?>
                <?php foreach ($data['recentApp'] as $app): ?>
                    <!-- A single application -->
                    <div class="row job-card"
                        data-id="<?= htmlspecialchars($app['ID']) ?>"
                        data-name="<?= htmlspecialchars($app['Fullname']) ?>"
                        onclick="viewApplication('<?= htmlspecialchars($app['PostID']) ?>', '<?= htmlspecialchars($app['Fullname']) ?>', '<?= htmlspecialchars($app['ID']) ?>')"
                        style="cursor: pointer;">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <h5><?= $app['Fullname'] ?></h5>
                                <span class="badge job-status-pending"><?= $app['Status'] ?></span>
                            </div>
                            <p class="mb-1">
                                <i class="bi bi-calendar3"></i> <?= $app['AppliedDate'] ?>
                                <i class="ml-4 bi bi-geo-alt"></i> <?= $app['Location'] ?>
                            </p>
                            <p class="mb-1">
                                <!-- <i class="bi bi-hash"></i> Software Engineer, JavaScript
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-clock-history"></i> > 2 years experience -->
                                <?= substr($app['Cover'], 0, min(strlen($app['Cover']), 50)); ?> ...
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</div>

<script>
    function viewJobPost(postId) {
        window.location.href = `${window.BASE_URL}/jobpost/view/${postId}/`
    }

    function viewApplication(postID, postname, appID) {
        window.location.href = `${window.BASE_URL}/applications/${postID}/${slugify(postname)}-${appID}/`
    }
</script>