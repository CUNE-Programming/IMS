/**------------------------------------------------------------
 * modals-controller.js
 * Ian Kollipara
 *
 * Description: This file contains the controller for the modals
 * that are used in the application.
 *------------------------------------------------------------**/

import { Controller } from "@hotwired/stimulus";

export default class ModalsController extends Controller {
  static targets = ["modal", "modalContainer"];

  modals = new Map();

  modalTargetConnected(el) {
    this.modals.set(el.dataset.modalId, el);
  }

  showModal(event) {
    let modalId = event.params["modalId"];
    if (!this.modals.has(modalId)) return;

    const modal = this.modals.get(modalId);

    this.modalContainerTarget.dataset.show = true;
    modal.dataset.show = true;
  }

  closeAllModals() {
    this.modalContainerTarget.dataset.show = false;
    this.modals.forEach(modal => {
      modal.dataset.show = false;
    });
  }

  hideModal(event) {
    let modalId = event.params["modalId"];
    if (!this.modals.has(modalId)) return;

    const modal = this.modals.get(modalId);
    modal.dataset.show = false;

    this.modalContainerTarget.dataset.show = false;
  }

  disconnect() {
    this.modals.clear();
  }

  noop() {
    return;
  }
}
