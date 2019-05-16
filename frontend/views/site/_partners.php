<div class="partners">

    <div class="js-str js-slider-partners- clearfix">

        <div class="partners__wrapper">

            <a href="https://kurs.expert" target="_blank" class="partners__item hovered" title="Анализатор обменников №1">
                <img src="https://kurs.expert/i/buttonY.png"/>
            </a>

            <?php for ($i = 1; $i < 9; $i++) {?>

                <?php if ($i == 1) { ?>
                    <a href="https://www.bestchange.ru/" class="partners__item hovered" target="_blank">

                        <img src="https://www.bestchange.ru/bestchange.gif"
                                title="Обмен Bitcoin, Perfect Money, Advanced Cash"
                                alt="Мониторинг обменных пунктов BestChange.ru" />
                    </a>
                <?php } else { ?>

                    <a href="javascript:void(0)" class="partners__item hovered"><img src="/images/partner_<?= $i ?>.png" alt=""></a>
                <?php } ?>


            <?php } ?>


            <a href="https://glazok.org/" target="_blank" class="partners__item hovered" title="Мониторинг обменных пунктов GLAZOK">
                <img src="https://glazok.org/88x31.gif" />
            </a>

        </div>

    </div>

</div>