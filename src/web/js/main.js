import { clearActiveState } from './clear-active-state';
import { readStockFromFile } from './read-stock-from-file';
// eslint-disable-next-line import/no-unassigned-import
import 'spectre.css';
import { createExcelFile } from './create-excel-file';

document.addEventListener('DOMContentLoaded', () => {
  const fileInput = document.querySelector('#file-upload');
  const getStock = document.querySelector('#get-stock');
  const loadingInfo = document.querySelector('#loading-info');
  const downloadTable = document.querySelector('#download-button');
  let JSONresult;

  console.log('🔥 let’s go, I’m ready to rock!');

  fileInput.addEventListener('change', (event) => {
    uploadFile(event, fileInput, loadingInfo).then((response) => {
      JSONresult = response;
    });
  });

  getStock.addEventListener('click', (event) => {
    uploadFile(event, fileInput, loadingInfo).then((response) => {
      JSONresult = response;
    });
  });

  downloadTable.addEventListener('click', (event) => {
    event.preventDefault();
    if (typeof JSONresult !== 'undefined' && JSONresult.body.length !== 0) {
      console.log('📥 downloading data as an excel file…');
      return createExcelFile(JSONresult.body);
    }

    console.log('☣️ there is no data to download');
  });
});

const uploadFile = (event, fileInput, loadingInfo) => {
  event.preventDefault();
  clearActiveState();
  if (fileInput.files.length === 1) {
    console.log('⏳ getting stock records…');
    loadingInfo.classList.add('active');
    return readStockFromFile(fileInput).then((response) => response);
  }

  fileInput.click();
};