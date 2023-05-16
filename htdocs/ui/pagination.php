<?php if ($count_pages > 0): ?>
    <nav aria-label="Page navigation" class="d-flex justify-content-center">
        <ul class="pagination pagination-sm">
            <?php if ($page > 1): ?>
                <li class="page-item prev"><a class="page-link"
                                              href="/<?=$inc?>.html<?= ($page - 1 > 1 ? '?page=' . ($page - 1) . (!empty((array)$url_parameters) ? '&' . $app->parseObject($url_parameters) : '') : (!empty((array)$url_parameters) ? '?' . $app->parseObject($url_parameters) : '')) ?>"
                                              aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
            <?php endif; ?>

            <?php if ($page > 3): ?>
                <li class="page-item start"><a class="page-link"
                                               href="/<?=$inc?>.html<?= (!empty((array)$url_parameters) ? '?' . $app->parseObject($url_parameters) : '') ?>">1</a>
                </li>
                <li class="page-item dots">...</li>
            <?php endif; ?>

            <?php if ($page - 2 > 0): ?>
                <li class="page-item page"><a class="page-link"
                                              href="/<?=$inc?>.html<?= ($page - 2 > 1 ? '?page=' . ($page - 2) . (!empty((array)$url_parameters) ? '&' . $app->parseObject($url_parameters) : '') : (!empty((array)$url_parameters) ? '?' . $app->parseObject($url_parameters) : '')) ?>"><?= ($page - 2) ?></a>
                </li>
            <?php endif; ?>
            <?php if ($page - 1 > 0): ?>
                <li class="page-item page"><a class="page-link"
                                              href="/<?=$inc?>.html<?= ($page - 1 > 1 ? '?page=' . ($page - 1) . (!empty((array)$url_parameters) ? '&' . $app->parseObject($url_parameters) : '') : (!empty((array)$url_parameters) ? '?' . $app->parseObject($url_parameters) : '')) ?>"><?= ($page - 1) ?></a>
                </li>
            <?php endif; ?>

            <li class="page-item active"><a class="page-link"
                                            href="/<?=$inc?>.html<?= ($page > 1 ? '?page=' . $page . (!empty((array)$url_parameters) ? '&' . $app->parseObject($url_parameters) : '') : (!empty((array)$url_parameters) ? '?' . $app->parseObject($url_parameters) : '')) ?>"><?= ($page) ?></a>
            </li>

            <?php if ($page + 1 < $count_pages + 1): ?>
                <li class="page-item page"><a class="page-link"
                                              href="/<?=$inc?>.html<?= ($page + 1 > 1 ? '?page=' . ($page + 1) . (!empty((array)$url_parameters) ? '&' . $app->parseObject($url_parameters) : '') : (!empty((array)$url_parameters) ? '?' . $app->parseObject($url_parameters) : '')) ?>"><?= ($page + 1) ?></a>
                </li>
            <?php endif; ?>
            <?php if ($page + 2 < $count_pages + 1): ?>
                <li class="page-item page"><a class="page-link"
                                              href="/<?=$inc?>.html<?= ($page + 2 > 1 ? '?page=' . ($page + 2) . (!empty((array)$url_parameters) ? '&' . $app->parseObject($url_parameters) : '') : (!empty((array)$url_parameters) ? '?' . $app->parseObject($url_parameters) : '')) ?>"><?= ($page + 2) ?></a>
                </li>
            <?php endif; ?>

            <?php if ($page < $count_pages - 2): ?>
                <li class="page-item dots">...</li>
                <li class="page-item end"><a class="page-link"
                                             href="/<?=$inc?>.html<?= ($count_pages > 1 ? '?page=' . $count_pages . (!empty((array)$url_parameters) ? '&' . $app->parseObject($url_parameters) : '') : (!empty((array)$url_parameters) ? '?' . $app->parseObject($url_parameters) : '')) ?>"><?= ($count_pages) ?></a>
                </li>
            <?php endif; ?>

            <?php if ($page < $count_pages): ?>
                <li class="page-item next"><a class="page-link"
                                              href="/<?=$inc?>.html<?= ($page + 1 > 1 ? '?page=' . ($page + 1) . (!empty((array)$url_parameters) ? '&' . $app->parseObject($url_parameters) : '') : (!empty((array)$url_parameters) ? '?' . $app->parseObject($url_parameters) : '')) ?>"
                                              aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
            <?php endif; ?>

        </ul>
    </nav>
<?php endif; ?>
