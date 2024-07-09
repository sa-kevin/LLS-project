import { useState } from 'react';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';

export default function DatePickerModal({ isOpen, onClose, onConfirm }) {
  const [returnDate, setReturnDate] = useState(null);

  const handleConfirm = () => {
    if (returnDate) {
      onConfirm(returnDate);
      onClose();
    } else {
      alert('Please select a return date.');
    }
  };
  if (!isOpen) {
    return null;
  }
  return (
    <div
      className="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full transition-opacity duration-300 ease-in-out"
      onClick={onClose}
    >
      <div
        className="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
        onClick={(e) => e.stopPropagation()}
      >
        <button
          onClick={onClose}
          className="absolute top-2 right-2 text-gray-500 hover:text-gray-700 focus:outline-none"
        >
          <svg
            className="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              strokeWidth={2}
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
        <div className="mt-3">
          <label className="block mb-2 text-sm font-medium text-gray-700">
            Select Return Date:
          </label>
          <DatePicker
            selected={returnDate}
            onChange={(date) => setReturnDate(date)}
            minDate={new Date()}
            className="border rounded py-2 px-3 text-gray-700"
          />
          <button
            onClick={handleConfirm}
            className="mt-2 px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
          >
            Confirm
          </button>
        </div>
      </div>
    </div>
  );
}
