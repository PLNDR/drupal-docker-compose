/** Navigate in submenu with arrow keys. */

const keyCodes = {
    ESCAPE: 27,
    UP: 38,
    DOWN: 40
}

const keysToListen = [keyCodes.DOWN, keyCodes.UP, keyCodes.ESCAPE]

jQuery(document).ready(function ($) {

    const getSubmenuState = () => {
        const focusedSubmenuItem = $('.menu-item button[aria-expanded="true"] ~ ul.sub-menu li a:focus')?.[0]
        const submenuItems = $('.menu-item button[aria-expanded="true"] ~ ul.sub-menu li a')

        return {
            openSubmenu: $('.menu-item button[aria-expanded="true"] ~ ul.sub-menu')?.[0],
            submenuTogglerButton: $('.menu-item button[aria-expanded="true"]')?.[0],
            submenuItems,
            currentFocusIndex: focusedSubmenuItem ? submenuItems?.index?.(focusedSubmenuItem) : -1,
        }
    }

    $(document).keydown(function (e) {

        const {
            openSubmenu,
            submenuItems,
            focusedSubmenuItem,
            currentFocusIndex,
            submenuTogglerButton
        } = getSubmenuState()

        if (!openSubmenu) return

        if (keysToListen.includes(e?.keyCode)) {
            e?.preventDefault?.()
            if (e?.keyCode === keyCodes.DOWN) {
                submenuItems?.[currentFocusIndex + 1]?.focus?.()
            }
            if (e?.keyCode === keyCodes.UP) {
                submenuItems?.[currentFocusIndex - 1]?.focus?.()
            }
            if (e?.keyCode === keyCodes.ESCAPE) {
                $(submenuTogglerButton)?.attr('aria-expanded', 'false')
            }
        }
    });

});