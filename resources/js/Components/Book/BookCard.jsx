export default function BookCard({
  book,
  onClose,
  onAddToWishlist,
  onRentOrWait,
}) {
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
          <div className="flex mb-4">
            <img
              src={book.imageUrl || 'images/brainBook.png'}
              alt={book.title}
              className="w-1/2 object-cover rounded-md"
            />
            <div className="ml-4 flex-1">
              <h3 className="text-xl font-bold text-gray-900">{book.title}</h3>
              <p className="text-sm text-gray-500 mt-3">{book.author}</p>
              <p className="text-sm text-gray-500 mt-1">{book.isbn}</p>
            </div>
          </div>

          <div className="mb-4">
            <p className="text-sm text-gray-700">Next available: 08/10 </p>
            <p className="text-sm text-gray-700">Waiting list: 2 peoples</p>
          </div>

          <p className="text-md text-gray-700 font-bold mb-2">Description:</p>
          <div className="text-sm text-gray-700 mb-4">{book.description}</div>

          <div className="flex justify-between gap-5 p-4">
            <button
              className="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
              onClick={onRentOrWait}
            >
              {book.isAvailable ? 'Rent Now' : ' Join Waitlist'}
            </button>
            <button
              className="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
              onClick={onAddToWishlist}
            >
              Add to Wishlist
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
